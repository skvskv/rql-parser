<?php
namespace Mrix\Rql\Parser\TokenParser;

use Mrix\Rql\Parser\Token;
use Mrix\Rql\Parser\TokenStream;
use Mrix\Rql\Parser\AbstractTokenParser;
use Mrix\Rql\Parser\Exception\UnknownOperatorException;
use Mrix\Rql\Parser\Node\AbstractQueryNode;

/**
 */
class QueryTokenParser extends AbstractTokenParser
{
    /**
     * @inheritdoc
     * @return AbstractQueryNode
     */
    public function parse(TokenStream $tokenStream)
    {
        return $this->getOperatorParser($tokenStream->getCurrent()->getValue())->parse($tokenStream);
    }

    /**
     * @inheritdoc
     */
    public function supports(Token $token)
    {
        return $token->test(Token::T_QUERY_OPERATOR);
    }

    /**
     * @param string $operator
     * @return QueryTokenParser
     * @throws UnknownOperatorException
     */
    protected function getOperatorParser($operator)
    {
        static $operatorMap = [
            'eq'        => Query\ScalarQuery\EqTokenParser::class,
            'ne'        => Query\ScalarQuery\NeTokenParser::class,
            'lt'        => Query\ScalarQuery\LtTokenParser::class,
            'gt'        => Query\ScalarQuery\GtTokenParser::class,
            'lte'       => Query\ScalarQuery\LteTokenParser::class,
            'gte'       => Query\ScalarQuery\GteTokenParser::class,

            'in'        => Query\ArrayQuery\InTokenParser::class,
            'out'       => Query\ArrayQuery\OutTokenParser::class,

            'and'       => Query\LogicQuery\AndTokenParser::class,
            'or'        => Query\LogicQuery\OrTokenParser::class,
            'not'       => Query\LogicQuery\NotTokenParser::class,
        ];

        if (!isset($operatorMap[$operator])) {
            throw new UnknownOperatorException(sprintf('Unknown operator "%s"', $operator));
        }

        $className = $operatorMap[$operator];
        return new $className;
    }
}