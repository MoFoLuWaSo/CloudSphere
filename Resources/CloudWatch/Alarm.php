<?php


namespace Resources\CloudWatch;


use Formation\Resource;
use Utils\ConditionalAdd;

class Alarm extends ConditionalAdd implements Resource
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