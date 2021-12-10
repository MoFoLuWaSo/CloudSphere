<?php


namespace Resources\IAM;


use Utils\ConditionalAdd;

class PolicyDocument extends ConditionalAdd
{

    private $version = "2012-10-17";
    private $statement = [];

    /**
     * PolicyDocument constructor.
     * @param $statement
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement->getStatements();
    }


    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param mixed $statement
     */
    public function setStatement(Statement $statement): void
    {
        $this->statement = $statement->getStatements();
    }


    public function getDocument()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "Version", $this->version);
        $properties = $this->conditionalAdd($properties, "Statement", $this->statement);


        return $properties;
    }
}