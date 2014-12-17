<?php

namespace Craue\GeoBundle\Doctrine\Functions;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\Lexer;

class GeoDistanceByPostalCode extends AbstractPlatformAwareFunctionNode
{
    /**
     * {@inheritdoc}
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->parameters['countryOrigin'] = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->parameters['postalCodeOrigin'] = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->parameters['countryDestination'] = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->parameters['postalCodeDestination'] = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
