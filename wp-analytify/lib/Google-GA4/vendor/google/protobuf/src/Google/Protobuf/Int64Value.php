<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/protobuf/wrappers.proto
namespace Google\Protobuf;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
/**
 * Wrapper message for `int64`.
 * The JSON representation for `Int64Value` is JSON string.
 *
 * Generated from protobuf message <code>google.protobuf.Int64Value</code>
 */
class Int64Value extends \Google\Protobuf\Internal\Message
{
    /**
     * The int64 value.
     *
     * Generated from protobuf field <code>int64 value = 1;</code>
     */
    protected $value = 0;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $value
     *           The int64 value.
     * }
     */
    public function __construct($data = NULL)
    {
        \GPBMetadata\Google\Protobuf\Wrappers::initOnce();
        parent::__construct($data);
    }
    /**
     * The int64 value.
     *
     * Generated from protobuf field <code>int64 value = 1;</code>
     * @return int|string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * The int64 value.
     *
     * Generated from protobuf field <code>int64 value = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkInt64($var);
        $this->value = $var;
        return $this;
    }
}
