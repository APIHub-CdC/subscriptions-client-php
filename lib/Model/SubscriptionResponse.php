<?php

namespace CirculoDeCredito\Subscriptions\Client\Model;

use \ArrayAccess;
use \CirculoDeCredito\Subscriptions\Client\ObjectSerializer;

class SubscriptionResponse implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    
    protected static $RCCPMModelName = 'subscriptionResponse';
    
    protected static $RCCPMTypes = [
        'event_type' => 'string',
        'web_hook_url' => 'string',
        'enrollment_id' => 'string',
        'subscription_id' => 'string',
        'date_time' => '\DateTime'
    ];
    
    protected static $RCCPMFormats = [
        'event_type' => null,
        'web_hook_url' => null,
        'enrollment_id' => 'uuid',
        'subscription_id' => 'uuid',
        'date_time' => 'date-time'
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
        'event_type' => 'eventType',
        'web_hook_url' => 'webHookUrl',
        'enrollment_id' => 'enrollmentId',
        'subscription_id' => 'subscriptionId',
        'date_time' => 'dateTime'
    ];
    
    protected static $setters = [
        'event_type' => 'setEventType',
        'web_hook_url' => 'setWebHookUrl',
        'enrollment_id' => 'setEnrollmentId',
        'subscription_id' => 'setSubscriptionId',
        'date_time' => 'setDateTime'
    ];
    
    protected static $getters = [
        'event_type' => 'getEventType',
        'web_hook_url' => 'getWebHookUrl',
        'enrollment_id' => 'getEnrollmentId',
        'subscription_id' => 'getSubscriptionId',
        'date_time' => 'getDateTime'
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
    const EVENT_TYPE_EVA = 'mx.com.circulodecredito.eva';
    const EVENT_TYPE_ADA = 'mx.com.circulodecredito.ada';
    const EVENT_TYPE_BAVS = 'mx.com.circulodecredito.bavs';
    const EVENT_TYPE_ODC = 'mx.com.circulodecredito.odc';
    const EVENT_TYPE_SAT = 'mx.com.circulodecredito.sat';
    
    
    
    public function getEventTypeAllowableValues()
    {
        return [
            self::EVENT_TYPE_EVA,
            self::EVENT_TYPE_ADA,
            self::EVENT_TYPE_BAVS,
            self::EVENT_TYPE_ODC,
            self::EVENT_TYPE_SAT,
        ];
    }
    
    
    protected $container = [];
    
    public function __construct(array $data = null)
    {
        $this->container['event_type'] = isset($data['event_type']) ? $data['event_type'] : null;
        $this->container['web_hook_url'] = isset($data['web_hook_url']) ? $data['web_hook_url'] : null;
        $this->container['enrollment_id'] = isset($data['enrollment_id']) ? $data['enrollment_id'] : null;
        $this->container['subscription_id'] = isset($data['subscription_id']) ? $data['subscription_id'] : null;
        $this->container['date_time'] = isset($data['date_time']) ? $data['date_time'] : null;
    }
    
    public function listInvalidProperties()
    {
        $invalidProperties = [];
        $allowedValues = $this->getEventTypeAllowableValues();
        if (!is_null($this->container['event_type']) && !in_array($this->container['event_type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'event_type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }
        if (!is_null($this->container['event_type']) && (mb_strlen($this->container['event_type']) > 50)) {
            $invalidProperties[] = "invalid value for 'event_type', the character length must be smaller than or equal to 50.";
        }
        if (!is_null($this->container['web_hook_url']) && (mb_strlen($this->container['web_hook_url']) > 100)) {
            $invalidProperties[] = "invalid value for 'web_hook_url', the character length must be smaller than or equal to 100.";
        }
        return $invalidProperties;
    }
    
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }
    
    public function getEventType()
    {
        return $this->container['event_type'];
    }
    
    public function setEventType($event_type)
    {
        $allowedValues = $this->getEventTypeAllowableValues();
        if (!is_null($event_type) && !in_array($event_type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'event_type', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        if (!is_null($event_type) && (mb_strlen($event_type) > 50)) {
            throw new \InvalidArgumentException('invalid length for $event_type when calling SubscriptionResponse., must be smaller than or equal to 50.');
        }
        $this->container['event_type'] = $event_type;
        return $this;
    }
    
    public function getWebHookUrl()
    {
        return $this->container['web_hook_url'];
    }
    
    public function setWebHookUrl($web_hook_url)
    {
        if (!is_null($web_hook_url) && (mb_strlen($web_hook_url) > 100)) {
            throw new \InvalidArgumentException('invalid length for $web_hook_url when calling SubscriptionResponse., must be smaller than or equal to 100.');
        }
        $this->container['web_hook_url'] = $web_hook_url;
        return $this;
    }
    
    public function getEnrollmentId()
    {
        return $this->container['enrollment_id'];
    }
    
    public function setEnrollmentId($enrollment_id)
    {
        $this->container['enrollment_id'] = $enrollment_id;
        return $this;
    }
    
    public function getSubscriptionId()
    {
        return $this->container['subscription_id'];
    }
    
    public function setSubscriptionId($subscription_id)
    {
        $this->container['subscription_id'] = $subscription_id;
        return $this;
    }
    
    public function getDateTime()
    {
        return $this->container['date_time'];
    }
    
    public function setDateTime($date_time)
    {
        $this->container['date_time'] = $date_time;
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
