<?php
namespace Mrix\Rql\Parser\Node\Query\ArrayOperator;

use Mrix\Rql\Parser\Node\Query\AbstractArrayOperatorNode;

/**
 */
class InNode extends AbstractArrayOperatorNode
{
    /**
     * @inheritdoc
     */
    public function getNodeName()
    {
        return 'in';
    }
}
