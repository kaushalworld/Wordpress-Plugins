<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Google\Analytics\Admin\V1alpha;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for UpdateSearchAds360Link RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.UpdateSearchAds360LinkRequest</code>
 */
class UpdateSearchAds360LinkRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The SearchAds360Link to update
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.SearchAds360Link search_ads_360_link = 1;</code>
     */
    private $search_ads_360_link = null;
    /**
     * Required. The list of fields to be updated. Omitted fields will not be
     * updated. To replace the entire entity, use one path with the string "*" to
     * match all fields.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $update_mask = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Admin\V1alpha\SearchAds360Link $search_ads_360_link
     *           The SearchAds360Link to update
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Required. The list of fields to be updated. Omitted fields will not be
     *           updated. To replace the entire entity, use one path with the string "*" to
     *           match all fields.
     * }
     */
    public function __construct($data = NULL)
    {
        \GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * The SearchAds360Link to update
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.SearchAds360Link search_ads_360_link = 1;</code>
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
     * The SearchAds360Link to update
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.SearchAds360Link search_ads_360_link = 1;</code>
     * @param \Google\Analytics\Admin\V1alpha\SearchAds360Link $var
     * @return $this
     */
    public function setSearchAds360Link($var)
    {
        GPBUtil::checkMessage($var, \Google\Analytics\Admin\V1alpha\SearchAds360Link::class);
        $this->search_ads_360_link = $var;
        return $this;
    }
    /**
     * Required. The list of fields to be updated. Omitted fields will not be
     * updated. To replace the entire entity, use one path with the string "*" to
     * match all fields.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }
    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }
    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }
    /**
     * Required. The list of fields to be updated. Omitted fields will not be
     * updated. To replace the entire entity, use one path with the string "*" to
     * match all fields.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;
        return $this;
    }
}
