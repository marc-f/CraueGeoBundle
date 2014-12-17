<?php

namespace Craue\GeoBundle\Doctrine\Functions\Platform\Postgresql;

use Doctrine\ORM\Query\SqlWalker;
use Craue\GeoBundle\Doctrine\Functions\Platform\PlatformFunctionNode;

/**
 * Usage: GEO_DISTANCE_BY_POSTAL_CODE(countryOrigin, postalCodeOrigin, countryDestination, postalCodeDestination)
 * Returns: distance in km
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2013 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class GeoDistanceByPostalCode extends PlatformFunctionNode
{
    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            '12756 * ASIN(SQRT(POWER(SIN(((SELECT lat FROM craue_geo_postalcode WHERE country = %s AND postal_code = %s) - (SELECT lat FROM craue_geo_postalcode WHERE country = %s AND postal_code = %s)) * PI()/360), 2) + COS((SELECT lat FROM craue_geo_postalcode WHERE country = %s AND postal_code = %s) * PI()/180) * COS((SELECT lat FROM craue_geo_postalcode WHERE country = %s AND postal_code = %s) * PI()/180) * POWER(SIN(((SELECT lng FROM craue_geo_postalcode WHERE country = %s AND postal_code = %s) - (SELECT lng FROM craue_geo_postalcode WHERE country = %s AND postal_code = %s)) *  PI()/360), 2)))',
            $sqlWalker->walkStringPrimary($this->parameters['countryOrigin']),
            $sqlWalker->walkStringPrimary($this->parameters['postalCodeOrigin']),
            $sqlWalker->walkStringPrimary($this->parameters['countryDestination']),
            $sqlWalker->walkStringPrimary($this->parameters['postalCodeDestination']),
            $sqlWalker->walkStringPrimary($this->parameters['countryOrigin']),
            $sqlWalker->walkStringPrimary($this->parameters['postalCodeOrigin']),
            $sqlWalker->walkStringPrimary($this->parameters['countryDestination']),
            $sqlWalker->walkStringPrimary($this->parameters['postalCodeDestination']),
            $sqlWalker->walkStringPrimary($this->parameters['countryOrigin']),
            $sqlWalker->walkStringPrimary($this->parameters['postalCodeOrigin']),
            $sqlWalker->walkStringPrimary($this->parameters['countryDestination']),
            $sqlWalker->walkStringPrimary($this->parameters['postalCodeDestination'])
        );
    }
}
