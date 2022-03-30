<?php


namespace Resources\EC2;


use Formation\Resource;
use Utils\ConditionalAdd;

class VPCGatewayAttachment extends ConditionalAdd implements Resource
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