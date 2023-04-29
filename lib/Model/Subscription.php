<?php

namespace CirculoDeCredito\Subscriptions\Client\Model;

use \ArrayAccess;
use \CirculoDeCredito\Subscriptions\Client\ObjectSerializer;

class Subscription implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    
    protected static $RCCPMModelName = 'subscription';
    
    protected static $RCCPMTypes = [
        'eventType' => 'string',
        'webHookUrl' => 'string',
        'enrollmentId' => 'string'
    ];
    
    protected static $RCCPMFormats = [
        'eventType' => null,
        'webHookUrl' => null,
        'enrollmentId' => 'uuid'
    ];
    
    public static function RCCPMTypes()
    {
        return self::$RCCPMTypes;
    }
    
    public static function RCCPMFormats()
    {
        return self::$RCCPMFormats;
    }
    
    protected static $attributeMap = [
        'eventType' => 'eventType',
        'webHookUrl' => 'webHookUrl',
        'enrollmentId' => 'enrollmentId'
    ];
    
    protected static $setters = [
        'eventType' => 'setEventType',
        'webHookUrl' => 'setWebHookUrl',
        'enrollmentId' => 'setEnrollmentId'
    ];
    
    protected static $getters = [
        'eventType' => 'getEventType',
        'webHookUrl' => 'getWebHookUrl',
        'enrollmentId' => 'getEnrollmentId'
    ];
    
    public static function attributeMap()
    {
        return self::$attributeMap;
    }
    
    public static function setters()
    {
        return self::$setters;
    }
    
    public static function getters()
    {
        return self::$getters;
    }
    
    public function getModelName()
    {
        return self::$RCCPMModelName;
    }
    const eventType_EVA = 'mx.com.circulodecredito.eva';
    const eventType_ADA = 'mx.com.circulodecredito.ada';
    const eventType_BAVS = 'mx.com.circulodecredito.bavs';
    const eventType_ODC = 'mx.com.circulodecredito.odc';
    const eventType_SAT = 'mx.com.circulodecredito.sat';
    
    
    
    public function getEventTypeAllowableValues()
    {
        return [
            self::eventType_EVA,
            self::eventType_ADA,
            self::eventType_BAVS,
            self::eventType_ODC,
            self::eventType_SAT,
        ];
    }
    
    
    protected $container = [];
    
    public function __construct(array $data = null)
    {
        $this->container['eventType'] = isset($data['eventType']) ? $data['eventType'] : null;
        $this->container['webHookUrl'] = isset($data['webHookUrl']) ? $data['webHookUrl'] : null;
        $this->container['enrollmentId'] = isset($data['enrollmentId']) ? $data['enrollmentId'] : null;
    }
    
    public function listInvalidProperties()
    {
        $invalidProperties = [];
        $allowedValues = $this->getEventTypeAllowableValues();
        if (!is_null($this->container['eventType']) && !in_array($this->container['eventType'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'eventType', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }
        if (!is_null($this->container['eventType']) && (mb_strlen($this->container['eventType']) > 50)) {
            $invalidProperties[] = "invalid value for 'eventType', the character length must be smaller than or equal to 50.";
        }
        if (!is_null($this->container['webHookUrl']) && (mb_strlen($this->container['webHookUrl']) > 100)) {
            $invalidProperties[] = "invalid value for 'webHookUrl', the character length must be smaller than or equal to 100.";
        }
        return $invalidProperties;
    }
    
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }
    
    public function getEventType()
    {
        return $this->container['eventType'];
    }
    
    public function setEventType($eventType)
    {
        $allowedValues = $this->getEventTypeAllowableValues();
        if (!is_null($eventType) && !in_array($eventType, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'eventType', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        if (!is_null($eventType) && (mb_strlen($eventType) > 50)) {
            throw new \InvalidArgumentException('invalid length for $eventType when calling Subscription., must be smaller than or equal to 50.');
        }
        $this->container['eventType'] = $eventType;
        return $this;
    }
    
    public function getWebHookUrl()
    {
        return $this->container['webHookUrl'];
    }
    
    public function setWebHookUrl($webHookUrl)
    {
        if (!is_null($webHookUrl) && (mb_strlen($webHookUrl) > 100)) {
            throw new \InvalidArgumentException('invalid length for $webHookUrl when calling Subscription., must be smaller than or equal to 100.');
        }
        $this->container['webHookUrl'] = $webHookUrl;
        return $this;
    }
    
    public function getEnrollmentId()
    {
        return $this->container['enrollmentId'];
    }
    
    public function setEnrollmentId($enrollmentId)
    {
        $this->container['enrollmentId'] = $enrollmentId;
        return $this;
    }
    
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }
    
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
    
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
    
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
