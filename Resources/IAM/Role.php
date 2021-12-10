<?php


namespace Resources\IAM;


use Formation\Resource;
use Utils\ConditionalAdd;

class Role extends ConditionalAdd implements Resource
{

    private $assumeRolePolicyDocument;
    private $description;
    private $managedPolicyArns;
    private $maxSessionDuration;
    private $path;
    private $permissionsBoundary;
    private $policies;
    private $roleName;
    private $tags;

    /**
     * Role constructor.
     * @param $assumeRolePolicyDocument
     * The trust policy that is associated with this role. Trust policies define which entities can assume the role. You can associate only one trust policy with a role. For an example of a policy that can be used to assume a role, see Template Examples. For more information about the elements that you can use in an IAM policy, see IAM Policy Elements Reference in the IAM User Guide.
     *
     * Required: Yes
     *
     * Type: Json
     *
     * Update requires: No interruption
     */
    public function __construct(PolicyDocument $assumeRolePolicyDocument)
    {
        $this->assumeRolePolicyDocument = $assumeRolePolicyDocument->getDocument();
    }

    /**
     * @param mixed $description
     * A description of the role that you provide.
     *
     * Required: No
     *
     * Type: String
     *
     * Maximum: 1000
     *
     * Pattern: [\p{L}\p{M}\p{Z}\p{S}\p{N}\p{P}]*
     *
     * Update requires: No interruption
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $managedPolicyArns
     * A list of Amazon Resource Names (ARNs) of the IAM managed policies that you want to attach to the role.
     *
     * For more information about ARNs, see Amazon Resource Names (ARNs) and AWS Service Namespaces in the AWS General Reference.
     *
     * Required: No
     *
     * Type: List of String
     *
     * Update requires: No interruption
     */
    public function setManagedPolicyArns($managedPolicyArns): void
    {
        $this->managedPolicyArns = $managedPolicyArns;
    }

    /**
     * @param mixed $paxSessionDuration
     * The maximum session duration (in seconds) that you want to set for the specified role. If you do not specify a value for this setting, the default maximum of one hour is applied. This setting can have a value from 1 hour to 12 hours.
     *
     * Anyone who assumes the role from the or API can use the DurationSeconds API parameter or the duration-seconds CLI parameter to request a longer session. The MaxSessionDuration setting determines the maximum duration that can be requested using the DurationSeconds parameter. If users don't specify a value for the DurationSeconds parameter, their security credentials are valid for one hour by default. This applies when you use the AssumeRole* API operations or the assume-role* CLI operations but does not apply when you use those operations to create a console URL. For more information, see Using IAM roles in the IAM User Guide.
     *
     * Required: No
     *
     * Type: Integer
     *
     * Minimum: 3600
     *
     * Maximum: 43200
     *
     * Update requires: No interruption
     */
    public function setMaxSessionDuration($maxSessionDuration): void
    {
        $this->maxSessionDuration = $maxSessionDuration;
    }

    /**
     * @param mixed $path
     * The path to the role. For more information about paths, see IAM Identifiers in the IAM User Guide.
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
     * @param mixed $permissionsBoundary
     * The ARN of the policy used to set the permissions boundary for the role.
     *
     * For more information about permissions boundaries, see Permissions boundaries for IAM identities in the IAM User Guide.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: No interruption
     */
    public function setPermissionsBoundary($permissionsBoundary): void
    {
        $this->permissionsBoundary = $permissionsBoundary;
    }

    /**
     * @param mixed $policies
     * Adds or updates an inline policy document that is embedded in the specified IAM role.
     *
     * When you embed an inline policy in a role, the inline policy is used as part of the role's access (permissions) policy. The role's trust policy is created at the same time as the role. You can update a role's trust policy later. For more information about IAM roles, go to Using Roles to Delegate Permissions and Federate Identities.
     *
     * A role can also have an attached managed policy. For information about policies, see Managed Policies and Inline Policies in the IAM User Guide.
     *
     * For information about limits on the number of inline policies that you can embed with a role, see Limitations on IAM Entities in the IAM User Guide.
     *
     * Note
     * If an external policy (such as AWS::IAM::Policy or AWS::IAM::ManagedPolicy) has a Ref to a role and if a resource (such as AWS::ECS::Service) also has a Ref to the same role, add a DependsOn attribute to the resource to make the resource depend on the external policy. This dependency ensures that the role's policy is available throughout the resource's lifecycle. For example, when you delete a stack with an AWS::ECS::Service resource, the DependsOn attribute ensures that AWS CloudFormation deletes the AWS::ECS::Service resource before deleting its role's policy.
     *
     * Required: No
     *
     * Type: List of Policy
     *
     * Update requires: No interruption
     */
    public function setPolicies($policies): void
    {
        $this->policies = $policies;
    }

    /**
     * @param mixed $roleName
     * A name for the IAM role, up to 64 characters in length. For valid values, see the RoleName parameter for the CreateRole action in the IAM User Guide.
     *
     * This parameter allows (per its regex pattern) a string of characters consisting of upper and lowercase alphanumeric characters with no spaces. You can also include any of the following characters: _+=,.@-. The role name must be unique within the account. Role names are not distinguished by case. For example, you cannot create roles named both "Role1" and "role1".
     *
     * If you don't specify a name, AWS CloudFormation generates a unique physical ID and uses that ID for the role name.
     *
     * If you specify a name, you must specify the CAPABILITY_NAMED_IAM value to acknowledge your template's capabilities. For more information, see Acknowledging IAM Resources in AWS CloudFormation Templates.
     *
     * Important
     * Naming an IAM resource can cause an unrecoverable error if you reuse the same template in multiple Regions. To prevent this, we recommend using Fn::Join and AWS::Region to create a Region-specific name, as in the following example: {"Fn::Join": ["", [{"Ref": "AWS::Region"}, {"Ref": "MyResourceName"}]]}.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setRoleName($roleName): void
    {
        $this->roleName = $roleName;
    }

    /**
     * @param mixed $tags
     * A list of tags that are attached to the role. For more information about tagging, see Tagging IAM resources in the IAM User Guide.
     *
     * Required: No
     *
     * Type: List of Tag
     *
     * Maximum: 50
     *
     * Update requires: No interruption
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }


    public function getRole()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "AssumeRolePolicyDocument", $this->assumeRolePolicyDocument);
        $properties = $this->conditionalAdd($properties, "Description", $this->description);
        $properties = $this->conditionalAdd($properties, "ManagedPolicyArns", $this->managedPolicyArns);
        $properties = $this->conditionalAdd($properties, "MaxSessionDuration", $this->maxSessionDuration);
        $properties = $this->conditionalAdd($properties, "Path", $this->path);
        $properties = $this->conditionalAdd($properties, "PermissionsBoundary", $this->permissionsBoundary);
        $properties = $this->conditionalAdd($properties, "Policies", $this->policies);
        $properties = $this->conditionalAdd($properties, "RoleName", $this->roleName);
        $properties = $this->conditionalAdd($properties, "Tags", $this->tags);

        return [
            "Type" => "AWS::IAM::Role",
            "Properties" => $properties
        ];
    }


    public function getResource()
    {
        // TODO: Implement getResource() method.

        return $this->getRole();
    }
}