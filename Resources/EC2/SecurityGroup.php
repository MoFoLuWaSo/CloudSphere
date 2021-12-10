<?php


namespace Resources\EC2;


use Formation\Resource;
use Utils\ConditionalAdd;

class SecurityGroup extends ConditionalAdd implements Resource
{

    private $groupDescription;
    private $groupName;
    private $securityGroupEgress;
    private $securityGroupIngress;
    private $tags;
    private $vpcId;

    /**
     * SecurityGroup constructor.
     * @param $groupDescription
     */
    public function __construct($groupDescription)
    {
        $this->groupDescription = $groupDescription;
    }

    /**
     * @param mixed $groupDescription
     * A description for the security group. This is informational only.
     *
     * Constraints: Up to 255 characters in length
     *
     * Constraints for EC2-Classic: ASCII characters
     *
     * Constraints for EC2-VPC: a-z, A-Z, 0-9, spaces, and ._-:/()#,@[]+=&;{}!$*
     *
     * Required: Yes
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setGroupDescription($groupDescription): void
    {
        $this->groupDescription = $groupDescription;
    }

    /**
     * @param mixed $groupName
     * The name of the security group.
     *
     * Constraints: Up to 255 characters in length. Cannot start with sg-.
     *
     * Constraints for EC2-Classic: ASCII characters
     *
     * Constraints for EC2-VPC: a-z, A-Z, 0-9, spaces, and ._-:/()#,@[]+=&;{}!$*
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setGroupName($groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @param mixed $securityGroupEgress
     * [VPC only] The outbound rules associated with the security group. There is a short interruption during which you cannot connect to the security group.
     *
     * Required: No
     *
     * Type: List of Egress
     *
     * Update requires: No interruption
     */
    public function setSecurityGroupEgress($securityGroupEgress): void
    {
        $this->securityGroupEgress = $securityGroupEgress;
    }

    /**
     * @param mixed $securityGroupIngress
     * The inbound rules associated with the security group.
     * There is a short interruption during which you cannot connect to the security group.
     *
     * Required: No
     *
     * Type: List of Ingress
     *
     * Update requires: No interruption
     */
    public function setSecurityGroupIngress($securityGroupIngress): void
    {
        $this->securityGroupIngress = $securityGroupIngress;
    }

    /**
     * @param mixed $tags
     * Any tags assigned to the security group.
     *
     * Required: No
     *
     * Type: List of Tag
     *
     * Update requires: No interruption
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @param mixed $vpcId
     * [VPC only] The ID of the VPC for the security group.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setVpcId($vpcId): void
    {
        $this->vpcId = $vpcId;
    }


    public function getSecurityGroup()
    {
        $properties = [];
        $properties["GroupDescription"] = $this->groupDescription;
        $properties = $this->conditionalAdd($properties, "GroupName", $this->groupName);
        $properties = $this->conditionalAdd($properties, "SecurityGroupEgress", $this->securityGroupEgress);
        $properties = $this->conditionalAdd($properties, "SecurityGroupIngress", $this->securityGroupIngress);
        $properties = $this->conditionalAdd($properties, "Tags", $this->tags);
        $properties = $this->conditionalAdd($properties, "VpcId", $this->vpcId);
        return [
            "Type" => "AWS::EC2::SecurityGroup",
            "Properties" => $properties
        ];
    }

    public function getResource()
    {
        // TODO: Implement getResource() method.
        return $this->getSecurityGroup();
    }
}