<?php
namespace Xiag\Rql\Parser;

use Xiag\Rql\Parser\Exception\UnknownTokenException;

class Token
{
    const T_END                 = -1;

    const T_INTEGER             = 1;
    const T_FLOAT               = 2;
    const T_STRING              = 3;
    const T_DATE                = 4;
    const T_GLOB                = 5;

    const T_CLOSE_PARENTHESIS   = 11;
    const T_OPEN_PARENTHESIS    = 12;
    const T_COMMA               = 13;
    const T_AMPERSAND           = 14;
    const T_VERTICAL_BAR        = 15;
    const T_PLUS                = 16;
    const T_MINUS               = 17;
    const T_COLON               = 18;

    const T_TYPE                = 31;

    const T_OPERATOR            = 41;

    const T_NULL                = 51;
    const T_EMPTY               = 52;
    const T_TRUE                = 53;
    const T_FALSE               = 54;

    /**
     * @var array Type<->Name mapping
     */
    public static $typeNameMap = [
        self::T_END               => 'T_END',

        self::T_INTEGER           => 'T_INTEGER',
        self::T_FLOAT             => 'T_FLOAT',
        self::T_STRING            => 'T_STRING',
        self::T_DATE              => 'T_DATE',
        self::T_GLOB              => 'T_GLOB',

        self::T_CLOSE_PARENTHESIS => 'T_CLOSE_PARENTHESIS',
        self::T_OPEN_PARENTHESIS  => 'T_OPEN_PARENTHESIS',
        self::T_COMMA             => 'T_COMMA',
        self::T_AMPERSAND         => 'T_AMPERSAND',
        self::T_VERTICAL_BAR      => 'T_VERTICAL_BAR',
        self::T_PLUS              => 'T_PLUS',
        self::T_MINUS             => 'T_MINUS',
        self::T_COLON             => 'T_COLON',

        self::T_TYPE              => 'T_TYPE',

        self::T_OPERATOR          => 'T_OPERATOR',

        self::T_NULL              => 'T_NULL',
        self::T_EMPTY             => 'T_EMPTY',
        self::T_TRUE              => 'T_TRUE',
        self::T_FALSE             => 'T_FALSE',
    ];

    /**
     * @var string
     */
    private $value;
    /**
     * @var int
     */
    private $type;
    /**
     * @var int
     */
    private $start;
    /**
     * @var int
     */
    private $end;

    /**
     * @param int $type
     * @param string $value
     * @param int $start
     * @param int $end
     */
    public function __construct($type, $value, $start, $end)
    {
        $this->type  = $type;
        $this->value = $value;
        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            return sprintf('%s(%s)', $this->getName(), $this->value);
        } catch (\Exception $e) {
            return sprintf('%s(%s)', 'UNKNOWN', $this->value);
        }
    }

    /**
     * @param int|int[] $type
     * @param string|string[] $value
     * @return bool
     */
    public function test($type, $value = null)
    {
        if (!in_array($this->type, (array)$type, true)) {
            return false;
        } elseif ($value !== null) {
            return in_array($this->value, (array)$value, true);
        } else {
            return true;
        }
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::getTypeName($this->type);
    }

    /**
     * @param int $type
     * @return string
     * @throws UnknownTokenException
     */
    public static function getTypeName($type)
    {
        if (!isset(static::$typeNameMap[$type])) {
            throw new UnknownTokenException(sprintf('Token of type "%s" does not exist', $type));
        }

        return static::$typeNameMap[$type];
    }
}
