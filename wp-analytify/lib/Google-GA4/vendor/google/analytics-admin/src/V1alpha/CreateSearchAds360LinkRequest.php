<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Google\Analytics\Admin\V1alpha;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for CreateSearchAds360Link RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.CreateSearchAds360LinkRequest</code>
 */
class CreateSearchAds360LinkRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * Required. The SearchAds360Link to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.SearchAds360Link search_ads_360_link = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $search_ads_360_link = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Example format: properties/1234
     *     @type \Google\Analytics\Admin\V1alpha\SearchAds360Link $search_ads_360_link
     *           Required. The SearchAds360Link to create.
     * }
     */
    public function __construct($data = NULL)
    {
        \GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Required. Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;
        return $this;
    }
    /**
     * Required. The SearchAds360Link to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.SearchAds360Link search_ads_360_link = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Analytics\Admin\V1alpha\SearchAds360Link|null
     */
    public function getSearchAds360Link()
    {
        return $this->search_ads_360_link;
    }
    public function hasSearchAds360Link()
    {
        return isset($this->search_ads_360_link);
    }
    public function clearSearchAds360Link()
    {
        unset($this->search_ads_360_link);
    }
    /**
     * Required. The SearchAds360Link to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.SearchAds360Link search_ads_360_link = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Analytics\Admin\V1alpha\SearchAds360Link $var
     * @return $this
     */
    public function setSearchAds360Link($var)
    {
        GPBUtil::checkMessage($var, \Google\Analytics\Admin\V1alpha\SearchAds360Link::class);
        $this->search_ads_360_link = $var;
        return $this;
    }
}
