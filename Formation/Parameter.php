<?php


namespace Formation;


use Utils\ConditionalAdd;

class Parameter extends ConditionalAdd
{

    private $allowedPattern;
    private $allowedValues;
    private $constraintDescription;
    private $default;
    private $description;
    private $maxLength;
    private $maxValue;
    private $minLength;
    private $minValue;
    private $noEcho;
    private $type;


    private array $params;

    /**
     * Parameter constructor.
     * @param $type
     */
    public function __construct( $type)
    {
        $this->type = $type;

    }


    /**
     * @param mixed $allowedPattern
     */
    public function setAllowedPattern($allowedPattern): void
    {
        $this->allowedPattern = $allowedPattern;
    }

    /**
     * @param mixed $allowedValues
     */
    public function setAllowedValues($allowedValues): void
    {
        $this->allowedValues = $allowedValues;
    }

    /**
     * @param mixed $constraintDescription
     */
    public function setConstraintDescription($constraintDescription): void
    {
        $this->constraintDescription = $constraintDescription;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default): void
    {
        $this->default = $default;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $maxLength
     */
    public function setMaxLength($maxLength): void
    {
        $this->maxLength = $maxLength;
    }

    /**
     * @param mixed $maxValue
     */
    public function setMaxValue($maxValue): void
    {
        $this->maxValue = $maxValue;
    }

    /**
     * @param mixed $minLength
     */
    public function setMinLength($minLength): void
    {
        $this->minLength = $minLength;
    }

    /**
     * @param mixed $minValue
     */
    public function setMinValue($minValue): void
    {
        $this->minValue = $minValue;
    }

    /**
     * @param mixed $noEcho
     */
    public function setNoEcho($noEcho): void
    {
        $this->noEcho = $noEcho;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


    public static function setDefaultParameter($name, array $values)
    {
        return [$name => $values];

    }

    public function getParameters()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "AllowedPattern", $this->allowedPattern);
        $properties = $this->conditionalAdd($properties, "AllowedValues", $this->allowedValues);
        $properties = $this->conditionalAdd($properties, "ConstraintDescription", $this->constraintDescription);
        $properties = $this->conditionalAdd($properties, "Default", $this->default);
        $properties = $this->conditionalAdd($properties, "Description", $this->description);
        $properties = $this->conditionalAdd($properties, "MaxLength", $this->maxLength);
        $properties = $this->conditionalAdd($properties, "MaxValue", $this->maxValue);
        $properties = $this->conditionalAdd($properties, "MinLength", $this->minLength);
        $properties = $this->conditionalAdd($properties, "MinValue", $this->minValue);
        $properties = $this->conditionalAdd($properties, "NoEcho", $this->noEcho);
        $properties["Type"] = $this->type;

        return $properties;

    }

}