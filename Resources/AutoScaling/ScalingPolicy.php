<?php


namespace Resources\AutoScaling;


use Formation\Resource;
use Utils\ConditionalAdd;

class ScalingPolicy extends ConditionalAdd implements Resource
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