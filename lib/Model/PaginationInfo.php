<?php

namespace CirculoDeCredito\Subscriptions\Client\Model;

use \ArrayAccess;
use \CirculoDeCredito\Subscriptions\Client\ObjectSerializer;

class PaginationInfo implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    
    protected static $RCCPMModelName = 'paginationInfo';
    
    protected static $RCCPMTypes = [
        'self' => 'string',
        'first' => 'string',
        'previous' => 'string',
        'next' => 'string',
        'last' => 'string'
    ];
    
    protected static $RCCPMFormats = [
        'self' => null,
        'first' => null,
        'previous' => null,
        'next' => null,
        'last' => null
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
        'self' => 'self',
        'first' => 'first',
        'previous' => 'previous',
        'next' => 'next',
        'last' => 'last'
    ];
    
    protected static $setters = [
        'self' => 'setSelf',
        'first' => 'setFirst',
        'previous' => 'setPrevious',
        'next' => 'setNext',
        'last' => 'setLast'
    ];
    
    protected static $getters = [
        'self' => 'getSelf',
        'first' => 'getFirst',
        'previous' => 'getPrevious',
        'next' => 'getNext',
        'last' => 'getLast'
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
        $this->container['self'] = isset($data['self']) ? $data['self'] : null;
        $this->container['first'] = isset($data['first']) ? $data['first'] : null;
        $this->container['previous'] = isset($data['previous']) ? $data['previous'] : null;
        $this->container['next'] = isset($data['next']) ? $data['next'] : null;
        $this->container['last'] = isset($data['last']) ? $data['last'] : null;
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
    
    public function getSelf()
    {
        return $this->container['self'];
    }
    
    public function setSelf($self)
    {
        $this->container['self'] = $self;
        return $this;
    }
    
    public function getFirst()
    {
        return $this->container['first'];
    }
    
    public function setFirst($first)
    {
        $this->container['first'] = $first;
        return $this;
    }
    
    public function getPrevious()
    {
        return $this->container['previous'];
    }
    
    public function setPrevious($previous)
    {
        $this->container['previous'] = $previous;
        return $this;
    }
    
    public function getNext()
    {
        return $this->container['next'];
    }
    
    public function setNext($next)
    {
        $this->container['next'] = $next;
        return $this;
    }
    
    public function getLast()
    {
        return $this->container['last'];
    }
    
    public function setLast($last)
    {
        $this->container['last'] = $last;
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
