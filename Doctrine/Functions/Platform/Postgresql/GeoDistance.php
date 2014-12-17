<?php

namespace Craue\GeoBundle\Doctrine\Functions\Platform\Postgresql;

use Doctrine\ORM\Query\SqlWalker;
use Craue\GeoBundle\Doctrine\Functions\Platform\PlatformFunctionNode;

/**
 * Usage: GEO_DISTANCE(latOrigin, lngOrigin, latDestination, lngDestination)
 * Returns: distance in km
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2013 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class GeoDistance extends PlatformFunctionNode
{
    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        /*
         * formula adapted from http://www.scribd.com/doc/2569355/Geo-Distance-Search-with-MySQL
         * originally returns distance in miles: 3956 * 2 * ASIN(SQRT(POWER(SIN((orig.lat - dest.lat) * PI()/180 / 2), 2) + COS(orig.lat * PI()/180) * COS(dest.lat * PI()/180) * POWER(SIN((orig.lon - dest.lon) *  PI()/180 / 2), 2)))
         */
        return sprintf(
            '12756 * ASIN(SQRT(POWER(SIN((%s::numeric - %s::numeric) * PI()/360), 2) + COS(%s::numeric * PI()/180) * COS(%s::numeric * PI()/180) * POWER(SIN((%s::numeric - %s::numeric) *  PI()/360), 2)))',
                $sqlWalker->walkArithmeticPrimary($this->parameters['latOrigin']),
                $sqlWalker->walkArithmeticPrimary($this->parameters['latDestination']),
                $sqlWalker->walkArithmeticPrimary($this->parameters['latOrigin']),
                $sqlWalker->walkArithmeticPrimary($this->parameters['latDestination']),
                $sqlWalker->walkArithmeticPrimary($this->parameters['lngOrigin']),
                $sqlWalker->walkArithmeticPrimary($this->parameters['lngDestination'])
            );
    }
}
