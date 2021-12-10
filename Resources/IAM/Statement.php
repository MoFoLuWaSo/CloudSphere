<?php


namespace Resources\IAM;


use Utils\ConditionalAdd;

class Statement extends ConditionalAdd
{
    private $effect;
    private $action;
    private $resource;
    private $condition;
    private $statements = [];
    private $principal;

    /**
     * @param mixed $effect
     */
    public function setEffect($effect): void
    {
        $this->effect = $effect;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @param mixed $principal
     */
    public function setPrincipal($principal): void
    {
        $this->principal = $principal;
    }


    public function getStatement()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "Effect", $this->effect);
        $properties = $this->conditionalAdd($properties, "Action", $this->action);
        $properties = $this->conditionalAdd($properties, "Resource", $this->resource);
        $properties = $this->conditionalAdd($properties, "Condition", $this->condition);
        $properties = $this->conditionalAdd($properties, "Principal", $this->principal);

        return $properties;
    }

    public function setStatement(Statement $statement)
    {
        $this->statements[] = $statement->getStatement();
    }

    /**
     * @return array
     */
    public function getStatements(): array
    {
        return $this->statements;
    }



}