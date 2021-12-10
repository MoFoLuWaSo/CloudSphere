<?php


namespace Formation;


use Utils\ConditionalAdd;

class Outputs extends ConditionalAdd
{

    private $logicalId;
    private $description;
    private $value;
    private $export;

    /**
     * Outputs constructor.
     * @param $logicalId
     */
    public function __construct($logicalId)
    {
        $this->logicalId = $logicalId;
    }

    /**
     * @return mixed
     */
    public function getLogicalId()
    {
        return $this->logicalId;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @param mixed $export
     */
    public function setExport($export): void
    {
        $this->export = $export;
    }

    public function getOutputs()
    {

        $output = [];
        $output = $this->conditionalAdd($output, "Description", $this->description);
        $output = $this->conditionalAdd($output, "Value", $this->value);
        $output = $this->conditionalAdd($output, "Export", $this->export);
        return $output;
    }


}