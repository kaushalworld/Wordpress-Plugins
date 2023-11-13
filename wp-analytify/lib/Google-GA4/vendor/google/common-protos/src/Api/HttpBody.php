<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/httpbody.proto
namespace Google\Api;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
/**
 * Message that represents an arbitrary HTTP body. It should only be used for
 * payload formats that can't be represented as JSON, such as raw binary or
 * an HTML page.
 * This message can be used both in streaming and non-streaming API methods in
 * the request as well as the response.
 * It can be used as a top-level request field, which is convenient if one
 * wants to extract parameters from either the URL or HTTP template into the
 * request fields and also want access to the raw HTTP body.
 * Example:
 *     message GetResourceRequest {
 *       // A unique request id.
 *       string request_id = 1;
 *       // The raw HTTP body is bound to this field.
 *       google.api.HttpBody http_body = 2;
 *     }
 *     service ResourceService {
 *       rpc GetResource(GetResourceRequest) returns (google.api.HttpBody);
 *       rpc UpdateResource(google.api.HttpBody) returns (google.protobuf.Empty);
 *     }
 * Example with streaming methods:
 *     service CaldavService {
 *       rpc GetCalendar(stream google.api.HttpBody)
 *         returns (stream google.api.HttpBody);
 *       rpc UpdateCalendar(stream google.api.HttpBody)
 *         returns (stream google.api.HttpBody);
 *     }
 * Use of this type only changes how the request and response bodies are
 * handled, all other features will continue to work unchanged.
 *
 * Generated from protobuf message <code>google.api.HttpBody</code>
 */
class HttpBody extends \Google\Protobuf\Internal\Message
{
    /**
     * The HTTP Content-Type string representing the content type of the body.
     *
     * Generated from protobuf field <code>string content_type = 1;</code>
     */
    private $content_type = '';
    /**
     * HTTP body binary data.
     *
     * Generated from protobuf field <code>bytes data = 2;</code>
     */
    private $data = '';
    /**
     * Application specific response metadata. Must be set in the first response
     * for streaming APIs.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.Any extensions = 3;</code>
     */
    private $extensions;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $content_type
     *           The HTTP Content-Type string representing the content type of the body.
     *     @type string $data
     *           HTTP body binary data.
     *     @type \Google\Protobuf\Any[]|\Google\Protobuf\Internal\RepeatedField $extensions
     *           Application specific response metadata. Must be set in the first response
     *           for streaming APIs.
     * }
     */
    public function __construct($data = NULL)
    {
        \GPBMetadata\Google\Api\Httpbody::initOnce();
        parent::__construct($data);
    }
    /**
     * The HTTP Content-Type string representing the content type of the body.
     *
     * Generated from protobuf field <code>string content_type = 1;</code>
     * @return string
     */
    public function getContentType()
    {
        return $this->content_type;
    }
    /**
     * The HTTP Content-Type string representing the content type of the body.
     *
     * Generated from protobuf field <code>string content_type = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setContentType($var)
    {
        GPBUtil::checkString($var, True);
        $this->content_type = $var;
        return $this;
    }
    /**
     * HTTP body binary data.
     *
     * Generated from protobuf field <code>bytes data = 2;</code>
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * HTTP body binary data.
     *
     * Generated from protobuf field <code>bytes data = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setData($var)
    {
        GPBUtil::checkString($var, False);
        $this->data = $var;
        return $this;
    }
    /**
     * Application specific response metadata. Must be set in the first response
     * for streaming APIs.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.Any extensions = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
    /**
     * Application specific response metadata. Must be set in the first response
     * for streaming APIs.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.Any extensions = 3;</code>
     * @param \Google\Protobuf\Any[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExtensions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Protobuf\Any::class);
        $this->extensions = $arr;
        return $this;
    }
}
