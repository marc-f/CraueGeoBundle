<?php

namespace Craue\GeoBundle\Doctrine\Functions;

use Doctrine\ORM\Query\QueryException;
use Doctrine\Common\Inflector\Inflector;

class FunctionFactory
{
    /**
     * Create platform function node.
     *
     * @param string $platformName
     * @param string $functionName
     * @param array $parameters
     * @throws \Doctrine\ORM\Query\QueryException
     * @return PlatformFunctionNode
     */
    public static function create($platformName, $functionName, array $parameters)
    {
        $className = __NAMESPACE__
            . '\\Platform\\'
            . Inflector::classify(strtolower($platformName))
            . '\\'
            . Inflector::classify(strtolower($functionName));
        
        if (!class_exists($className)) {
            throw QueryException::syntaxError(
                sprintf(
                    'Function "%s" does not supported for platform "%s"',
                    $functionName,
                    $platformName
                )
            );
        }

        return new $className($parameters);
    }
}
