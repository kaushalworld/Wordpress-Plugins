<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/access_report.proto
namespace Google\Analytics\Admin\V1alpha;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
/**
 * The value of a metric.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.AccessMetricValue</code>
 */
class AccessMetricValue extends \Google\Protobuf\Internal\Message
{
    /**
     * The measurement value. For example, this value may be '13'.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     */
    private $value = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $value
     *           The measurement value. For example, this value may be '13'.
     * }
     */
    public function __construct($data = NULL)
    {
        \GPBMetadata\Google\Analytics\Admin\V1Alpha\AccessReport::initOnce();
        parent::__construct($data);
    }
    /**
     * The measurement value. For example, this value may be '13'.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * The measurement value. For example, this value may be '13'.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;
        return $this;
    }
}
