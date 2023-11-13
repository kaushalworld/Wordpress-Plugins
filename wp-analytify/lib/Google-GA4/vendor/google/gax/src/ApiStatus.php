<?php

/*
 * Copyright 2017 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore;

use Google\Rpc\Code;
class ApiStatus
{
    const OK = 'OK';
    const CANCELLED = 'CANCELLED';
    const UNKNOWN = 'UNKNOWN';
    const INVALID_ARGUMENT = 'INVALID_ARGUMENT';
    const DEADLINE_EXCEEDED = 'DEADLINE_EXCEEDED';
    const NOT_FOUND = 'NOT_FOUND';
    const ALREADY_EXISTS = 'ALREADY_EXISTS';
    const PERMISSION_DENIED = 'PERMISSION_DENIED';
    const RESOURCE_EXHAUSTED = 'RESOURCE_EXHAUSTED';
    const FAILED_PRECONDITION = 'FAILED_PRECONDITION';
    const ABORTED = 'ABORTED';
    const OUT_OF_RANGE = 'OUT_OF_RANGE';
    const UNIMPLEMENTED = 'UNIMPLEMENTED';
    const INTERNAL = 'INTERNAL';
    const UNAVAILABLE = 'UNAVAILABLE';
    const DATA_LOSS = 'DATA_LOSS';
    const UNAUTHENTICATED = 'UNAUTHENTICATED';
    const UNRECOGNIZED_STATUS = 'UNRECOGNIZED_STATUS';
    const UNRECOGNIZED_CODE = -1;
    private static $apiStatusToCodeMap = [\Google\ApiCore\ApiStatus::OK => Code::OK, \Google\ApiCore\ApiStatus::CANCELLED => Code::CANCELLED, \Google\ApiCore\ApiStatus::UNKNOWN => Code::UNKNOWN, \Google\ApiCore\ApiStatus::INVALID_ARGUMENT => Code::INVALID_ARGUMENT, \Google\ApiCore\ApiStatus::DEADLINE_EXCEEDED => Code::DEADLINE_EXCEEDED, \Google\ApiCore\ApiStatus::NOT_FOUND => Code::NOT_FOUND, \Google\ApiCore\ApiStatus::ALREADY_EXISTS => Code::ALREADY_EXISTS, \Google\ApiCore\ApiStatus::PERMISSION_DENIED => Code::PERMISSION_DENIED, \Google\ApiCore\ApiStatus::RESOURCE_EXHAUSTED => Code::RESOURCE_EXHAUSTED, \Google\ApiCore\ApiStatus::FAILED_PRECONDITION => Code::FAILED_PRECONDITION, \Google\ApiCore\ApiStatus::ABORTED => Code::ABORTED, \Google\ApiCore\ApiStatus::OUT_OF_RANGE => Code::OUT_OF_RANGE, \Google\ApiCore\ApiStatus::UNIMPLEMENTED => Code::UNIMPLEMENTED, \Google\ApiCore\ApiStatus::INTERNAL => Code::INTERNAL, \Google\ApiCore\ApiStatus::UNAVAILABLE => Code::UNAVAILABLE, \Google\ApiCore\ApiStatus::DATA_LOSS => Code::DATA_LOSS, \Google\ApiCore\ApiStatus::UNAUTHENTICATED => Code::UNAUTHENTICATED];
    private static $codeToApiStatusMap = [Code::OK => \Google\ApiCore\ApiStatus::OK, Code::CANCELLED => \Google\ApiCore\ApiStatus::CANCELLED, Code::UNKNOWN => \Google\ApiCore\ApiStatus::UNKNOWN, Code::INVALID_ARGUMENT => \Google\ApiCore\ApiStatus::INVALID_ARGUMENT, Code::DEADLINE_EXCEEDED => \Google\ApiCore\ApiStatus::DEADLINE_EXCEEDED, Code::NOT_FOUND => \Google\ApiCore\ApiStatus::NOT_FOUND, Code::ALREADY_EXISTS => \Google\ApiCore\ApiStatus::ALREADY_EXISTS, Code::PERMISSION_DENIED => \Google\ApiCore\ApiStatus::PERMISSION_DENIED, Code::RESOURCE_EXHAUSTED => \Google\ApiCore\ApiStatus::RESOURCE_EXHAUSTED, Code::FAILED_PRECONDITION => \Google\ApiCore\ApiStatus::FAILED_PRECONDITION, Code::ABORTED => \Google\ApiCore\ApiStatus::ABORTED, Code::OUT_OF_RANGE => \Google\ApiCore\ApiStatus::OUT_OF_RANGE, Code::UNIMPLEMENTED => \Google\ApiCore\ApiStatus::UNIMPLEMENTED, Code::INTERNAL => \Google\ApiCore\ApiStatus::INTERNAL, Code::UNAVAILABLE => \Google\ApiCore\ApiStatus::UNAVAILABLE, Code::DATA_LOSS => \Google\ApiCore\ApiStatus::DATA_LOSS, Code::UNAUTHENTICATED => \Google\ApiCore\ApiStatus::UNAUTHENTICATED];
    private static $httpStatusCodeToRpcCodeMap = [400 => Code::INVALID_ARGUMENT, 401 => Code::UNAUTHENTICATED, 403 => Code::PERMISSION_DENIED, 404 => Code::NOT_FOUND, 409 => Code::ABORTED, 416 => Code::OUT_OF_RANGE, 429 => Code::RESOURCE_EXHAUSTED, 499 => Code::CANCELLED, 501 => Code::UNIMPLEMENTED, 503 => Code::UNAVAILABLE, 504 => Code::DEADLINE_EXCEEDED];
    /**
     * @param string $status
     * @return bool
     */
    public static function isValidStatus(string $status)
    {
        return \array_key_exists($status, self::$apiStatusToCodeMap);
    }
    /**
     * @param int $code
     * @return string
     */
    public static function statusFromRpcCode(int $code)
    {
        if (\array_key_exists($code, self::$codeToApiStatusMap)) {
            return self::$codeToApiStatusMap[$code];
        }
        return \Google\ApiCore\ApiStatus::UNRECOGNIZED_STATUS;
    }
    /**
     * @param string $status
     * @return int
     */
    public static function rpcCodeFromStatus(string $status)
    {
        if (\array_key_exists($status, self::$apiStatusToCodeMap)) {
            return self::$apiStatusToCodeMap[$status];
        }
        return \Google\ApiCore\ApiStatus::UNRECOGNIZED_CODE;
    }
    /**
     * Maps HTTP status codes to Google\Rpc\Code codes.
     * Some codes are left out because they map to multiple gRPC codes (e.g. 500).
     *
     * @param int $httpStatusCode
     * @return int
     */
    public static function rpcCodeFromHttpStatusCode(int $httpStatusCode)
    {
        if (\array_key_exists($httpStatusCode, self::$httpStatusCodeToRpcCodeMap)) {
            return self::$httpStatusCodeToRpcCodeMap[$httpStatusCode];
        }
        // All 2xx
        if ($httpStatusCode >= 200 && $httpStatusCode < 300) {
            return Code::OK;
        }
        // All 4xx
        if ($httpStatusCode >= 400 && $httpStatusCode < 500) {
            return Code::FAILED_PRECONDITION;
        }
        // All 5xx
        if ($httpStatusCode >= 500 && $httpStatusCode < 600) {
            return Code::INTERNAL;
        }
        // Everything else (We cannot change this to Code::UNKNOWN because it would break BC)
        return \Google\ApiCore\ApiStatus::UNRECOGNIZED_CODE;
    }
}
