<?php
namespace Xiag\Rql\Parser\Node\Query;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractArrayOperatorNode extends AbstractComparisonOperatorNode
{
    /**
     * @var array
     */
    protected $values;

    /**
     * @param string $field
     * @param array $values
     */
    public function __construct($field, array $values)
    {
        $this->field = $field;
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     * @return void
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }
}
