<?php

namespace Formation;

use Utils\ConditionalAdd;

/*
 * Create this Template object
 */

class Template extends ConditionalAdd
{
    private $version;
    private $description;
    private $metadata;
    private $parameters = [];
    private $rules;
    private $mappings = [];
    private $conditions;
    private $transforms;
    private $resources = [];
    private $outputs = [];

    public function addResources($logicalName, Resource $resources)
    {
        $this->resources[$logicalName] = $resources->getResource();
    }

    public function addDescription($description)
    {
        $this->description = $description;
    }

    public function addParameter($logicalId, Parameter $parameter)
    {
        $this->parameters[$logicalId] = $parameter->getParameters();
    }

    public function addMappings($mappings)
    {
        $this->mappings = array_merge($this->mappings, $mappings);
    }

    public function addOutputs(Outputs $outputs)
    {
        $this->outputs[$outputs->getLogicalId()] = $outputs->getOutputs();
    }

    public function setMetadata(Metadata $metadata): void
    {
        $this->metadata = $metadata->getData();
    }

    public function generateTemplate($name)
    {

        $temp = [];
        $temp = $this->conditionalAdd($temp, "AWSTemplateFormatVersion", $this->version);
        $temp = $this->conditionalAdd($temp, "Description", $this->description);
        $temp = $this->conditionalAdd($temp, "Metadata", $this->metadata);
        $temp = $this->conditionalAdd($temp, "Parameters", $this->parameters);
        $temp = $this->conditionalAdd($temp, "Rules", $this->rules);
        $temp = $this->conditionalAdd($temp, "Mappings", $this->mappings);
        $temp = $this->conditionalAdd($temp, "Conditions", $this->conditions);
        $temp = $this->conditionalAdd($temp, "Transform", $this->transforms);
        $temp["Resources"] = $this->resources;
        $temp = $this->conditionalAdd($temp, "Outputs", $this->outputs);
        $temp = $this->conditionalAdd($temp, "AWSTemplateFormatVersion", $this->version);
        $data = json_encode($temp, JSON_PRETTY_PRINT);
        file_put_contents("PublishedTemplates/" . $name . ".template", $data);
        return $data;
    }


}