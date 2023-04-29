<?php

namespace CirculoDeCredito\Subscriptions\Client\Model;

use \ArrayAccess;
use \CirculoDeCredito\Subscriptions\Client\ObjectSerializer;

class Pagination implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    
    protected static $RCCPMModelName = 'pagination';
    
    protected static $RCCPMTypes = [
        'page' => 'int',
        'per_page' => 'int',
        'page_count' => 'int',
        'total_count' => 'int',
        'links' => '\CirculoDeCredito\Subscriptions\Client\Model\PaginationInfo'
    ];
    
    protected static $RCCPMFormats = [
        'page' => null,
        'per_page' => null,
        'page_count' => null,
        'total_count' => null,
        'links' => null
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
        'page' => 'page',
        'per_page' => 'perPage',
        'page_count' => 'pageCount',
        'total_count' => 'totalCount',
        'links' => 'links'
    ];
    
    protected static $setters = [
        'page' => 'setPage',
        'per_page' => 'setPerPage',
        'page_count' => 'setPageCount',
        'total_count' => 'setTotalCount',
        'links' => 'setLinks'
    ];
    
    protected static $getters = [
        'page' => 'getPage',
        'per_page' => 'getPerPage',
        'page_count' => 'getPageCount',
        'total_count' => 'getTotalCount',
        'links' => 'getLinks'
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
        $this->container['page'] = isset($data['page']) ? $data['page'] : null;
        $this->container['per_page'] = isset($data['per_page']) ? $data['per_page'] : null;
        $this->container['page_count'] = isset($data['page_count']) ? $data['page_count'] : null;
        $this->container['total_count'] = isset($data['total_count']) ? $data['total_count'] : null;
        $this->container['links'] = isset($data['links']) ? $data['links'] : null;
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
    
    public function getPage()
    {
        return $this->container['page'];
    }
    
    public function setPage($page)
    {
        $this->container['page'] = $page;
        return $this;
    }
    
    public function getPerPage()
    {
        return $this->container['per_page'];
    }
    
    public function setPerPage($per_page)
    {
        $this->container['per_page'] = $per_page;
        return $this;
    }
    
    public function getPageCount()
    {
        return $this->container['page_count'];
    }
    
    public function setPageCount($page_count)
    {
        $this->container['page_count'] = $page_count;
        return $this;
    }
    
    public function getTotalCount()
    {
        return $this->container['total_count'];
    }
    
    public function setTotalCount($total_count)
    {
        $this->container['total_count'] = $total_count;
        return $this;
    }
    
    public function getLinks()
    {
        return $this->container['links'];
    }
    
    public function setLinks($links)
    {
        $this->container['links'] = $links;
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
