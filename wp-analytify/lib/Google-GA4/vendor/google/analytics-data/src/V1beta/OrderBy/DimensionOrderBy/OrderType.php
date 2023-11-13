<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1beta/data.proto
namespace Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy;

use UnexpectedValueException;
/**
 * Rule to order the string dimension values by.
 *
 * Protobuf type <code>google.analytics.data.v1beta.OrderBy.DimensionOrderBy.OrderType</code>
 */
class OrderType
{
    /**
     * Unspecified.
     *
     * Generated from protobuf enum <code>ORDER_TYPE_UNSPECIFIED = 0;</code>
     */
    const ORDER_TYPE_UNSPECIFIED = 0;
    /**
     * Alphanumeric sort by Unicode code point. For example, "2" < "A" < "X" <
     * "b" < "z".
     *
     * Generated from protobuf enum <code>ALPHANUMERIC = 1;</code>
     */
    const ALPHANUMERIC = 1;
    /**
     * Case insensitive alphanumeric sort by lower case Unicode code point.
     * For example, "2" < "A" < "b" < "X" < "z".
     *
     * Generated from protobuf enum <code>CASE_INSENSITIVE_ALPHANUMERIC = 2;</code>
     */
    const CASE_INSENSITIVE_ALPHANUMERIC = 2;
    /**
     * Dimension values are converted to numbers before sorting. For example
     * in NUMERIC sort, "25" < "100", and in `ALPHANUMERIC` sort, "100" <
     * "25". Non-numeric dimension values all have equal ordering value below
     * all numeric values.
     *
     * Generated from protobuf enum <code>NUMERIC = 3;</code>
     */
    const NUMERIC = 3;
    private static $valueToName = [self::ORDER_TYPE_UNSPECIFIED => 'ORDER_TYPE_UNSPECIFIED', self::ALPHANUMERIC => 'ALPHANUMERIC', self::CASE_INSENSITIVE_ALPHANUMERIC => 'CASE_INSENSITIVE_ALPHANUMERIC', self::NUMERIC => 'NUMERIC'];
    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(\sprintf('Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }
    public static function value($name)
    {
        $const = __CLASS__ . '::' . \strtoupper($name);
        if (!\defined($const)) {
            throw new UnexpectedValueException(\sprintf('Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return \constant($const);
    }
}
