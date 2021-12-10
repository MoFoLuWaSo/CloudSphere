<?php


namespace Resources\IAM;


use Formation\Resource;
use Utils\ConditionalAdd;

class InstanceProfile extends ConditionalAdd implements Resource
{
    private $instanceProfileName;
    private $path;
    private $roles =[];

    /**
     * InstanceProfile constructor.
     * @param $roles
     */
    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param mixed $instanceProfileName
     * The name of the instance profile to create.
     *
     * This parameter allows (through its regex pattern) a string of characters consisting of upper and lowercase alphanumeric characters with no spaces. You can also include any of the following characters: _+=,.@-
     *
     * Required: No
     *
     * Type: String
     *
     * Minimum: 1
     *
     * Maximum: 128
     *
     * Pattern: [\w+=,.@-]+
     *
     * Update requires: Replacement
     */
    public function setInstanceProfileName($instanceProfileName): void
    {
        $this->instanceProfileName = $instanceProfileName;
    }

    /**
     * @param mixed $path
     * The path to the instance profile. For more information about paths, see IAM Identifiers in the IAM User Guide.
     *
     * This parameter is optional. If it is not included, it defaults to a slash (/).
     *
     * This parameter allows (through its regex pattern) a string of characters consisting of either a forward slash (/) by itself or a string that must begin and end with forward slashes. In addition, it can contain any ASCII character from the ! (\u0021) through the DEL character (\u007F), including most punctuation characters, digits, and upper and lowercased letters.
     *
     * Required: No
     *
     * Type: String
     *
     * Minimum: 1
     *
     * Maximum: 512
     *
     * Pattern: (\u002F)|(\u002F[\u0021-\u007F]+\u002F)
     *
     * Update requires: Replacement
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @param mixed $roles
     * The name of the role to associate with the instance profile. Only one role can be assigned to an EC2 instance at a time, and all applications on the instance share the same role and permissions.
     *
     * Required: Yes
     *
     * Type: List of String
     *
     * Update requires: No interruption
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }


    public function getInstanceProfile()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "InstanceProfileName", $this->instanceProfileName);
        $properties = $this->conditionalAdd($properties, "Path", $this->path);
        $properties = $this->conditionalAdd($properties, "Roles", $this->roles);

        return [
            "Type" => "AWS::IAM::InstanceProfile",
            "Properties" => $properties
        ];
    }

    public function getResource()
    {
        // TODO: Implement getResource() method.
        return $this->getInstanceProfile();
    }
}