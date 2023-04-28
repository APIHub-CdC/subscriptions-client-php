<?php

namespace CirculoDeCredito\Subscriptions\Client\Model;

use \ArrayAccess;
use \CirculoDeCredito\Subscriptions\Client\ObjectSerializer;

class ListSubscriptions implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    
    protected static $RCCPMModelName = 'listSubscriptions';
    
    protected static $RCCPMTypes = [
        '_metadata' => '\CirculoDeCredito\Subscriptions\Client\Model\Pagination',
        'subscriptions' => '\CirculoDeCredito\Subscriptions\Client\Model\SubscriptionResponseArray'
    ];
    
    protected static $RCCPMFormats = [
        '_metadata' => null,
        'subscriptions' => null
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
        '_metadata' => '_metadata',
        'subscriptions' => 'subscriptions'
    ];
    
    protected static $setters = [
        '_metadata' => 'setMetadata',
        'subscriptions' => 'setSubscriptions'
    ];
    
    protected static $getters = [
        '_metadata' => 'getMetadata',
        'subscriptions' => 'getSubscriptions'
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
    
    
    
    protected $container = [];
    
    public function __construct(array $data = null)
    {
        $this->container['_metadata'] = isset($data['_metadata']) ? $data['_metadata'] : null;
        $this->container['subscriptions'] = isset($data['subscriptions']) ? $data['subscriptions'] : null;
    }
    
    public function listInvalidProperties()
    {
        $invalidProperties = [];
        return $invalidProperties;
    }
    
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }
    
    public function getMetadata()
    {
        return $this->container['_metadata'];
    }
    
    public function setMetadata($_metadata)
    {
        $this->container['_metadata'] = $_metadata;
        return $this;
    }
    
    public function getSubscriptions()
    {
        return $this->container['subscriptions'];
    }
    
    public function setSubscriptions($subscriptions)
    {
        $this->container['subscriptions'] = $subscriptions;
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
