<?php

namespace Craue\GeoBundle\Doctrine\Functions;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\Lexer;

class GeoDistance extends AbstractPlatformAwareFunctionNode
{
    /**
     * {@inheritdoc}
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->parameters['latOrigin'] = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->parameters['lngOrigin'] = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->parameters['latDestination'] = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->parameters['lngDestination'] = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
