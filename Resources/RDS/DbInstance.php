<?php


namespace Resources\RDS;


use Formation\Resource;
use Utils\ConditionalAdd;

class DbInstance extends ConditionalAdd implements Resource
{
    private $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        // TODO: Implement getResource() method.
        return $this->resource;
    }


}