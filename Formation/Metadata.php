<?php


namespace Formation;


use MetaData\CloudFormation\Init;

class Metadata
{
    private $data;

    /**
     * Metadata constructor.
     * @param $data
     */
    public function __construct()
    {

    }

    public function addInfo($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function addInit(Init $init)
    {
        $this->data[CloudFormationInit] = $init->getConfigurations();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


}