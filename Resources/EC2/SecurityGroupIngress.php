<?php


namespace Resources\EC2;



use Utils\ConditionalAdd;

class SecurityGroupIngress extends ConditionalAdd
{
    private $cidrIp;
    private $cidrIpv6;
    private $description;
    private $fromPort;
    private $groupId;
    private $groupName;
    private $ipProtocol;
    private $sourcePrefixListId;
    private $sourceSecurityGroupId;
    private $sourceSecurityGroupName;
    private $sourceSecurityGroupOwnerId;
    private $toPort;

    /**
     * SecurityGroupIngress constructor.
     * @param $ipProtocol
     */
    public function __construct($ipProtocol)
    {
        $this->ipProtocol = $ipProtocol;
    }

    /**
     * @param mixed $cidrIp
     * The IPv4 address range, in CIDR format.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setCidrIp($cidrIp): void
    {
        $this->cidrIp = $cidrIp;
    }

    /**
     * @param mixed $cidrIpv6
     * The IPv6 address range, in CIDR format.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setCidrIpv6($cidrIpv6): void
    {
        $this->cidrIpv6 = $cidrIpv6;
    }

    /**
     * @param mixed $description
     * Updates the description of an ingress (inbound) security group rule.
     * You can replace an existing description, or add a description to a rule that did not have one previously.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: No interruption
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $fromPort
     * The start of port range for the TCP and UDP protocols, or an ICMP/ICMPv6 type number.
     * A value of -1 indicates all ICMP/ICMPv6 types.
     * If you specify all ICMP/ICMPv6 types, you must specify all codes.
     *
     * Use this for ICMP and any protocol that uses ports.
     *
     * Required: No
     *
     * Type: Integer
     *
     * Update requires: Replacement
     *
     */
    public function setFromPort($fromPort): void
    {
        $this->fromPort = $fromPort;
    }

    /**
     * @param mixed $groupId
     * The ID of the security group.
     * You must specify either the security group ID or the security group name in the request.
     * For security groups in a nondefault VPC, you must specify the security group ID.
     *
     * You must specify the GroupName property or the GroupId property.
     * For security groups that are in a VPC, you must use the GroupId property.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
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
     * @param mixed $ipProtocol
     * The IP protocol name (tcp, udp, icmp, icmpv6) or number (see Protocol Numbers).
     *
     * [VPC only] Use -1 to specify all protocols.
     * When authorizing security group rules, specifying -1 or a protocol number other than tcp, udp, icmp, or icmpv6 allows traffic on all ports, regardless of any port range you specify. For tcp, udp, and icmp, you must specify a port range. For icmpv6, the port range is optional; if you omit the port range, traffic for all types and codes is allowed.
     *
     * Required: Yes
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setIpProtocol($ipProtocol): void
    {
        $this->ipProtocol = $ipProtocol;
    }

    /**
     * @param mixed $sourcePrefixListId
     * [EC2-VPC only] The ID of a prefix list.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setSourcePrefixListId($sourcePrefixListId): void
    {
        $this->sourcePrefixListId = $sourcePrefixListId;
    }

    /**
     * @param mixed $sourceSecurityGroupId
     * The ID of the security group. You must specify either the security group ID or the security group name.
     * For security groups in a nondefault VPC, you must specify the security group ID.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setSourceSecurityGroupId($sourceSecurityGroupId): void
    {
        $this->sourceSecurityGroupId = $sourceSecurityGroupId;
    }

    /**
     * @param mixed $sourceSecurityGroupName
     * [EC2-Classic, default VPC] The name of the source security group.
     *
     * You must specify the GroupName property or the GroupId property.
     * For security groups that are in a VPC, you must use the GroupId property.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setSourceSecurityGroupName($sourceSecurityGroupName): void
    {
        $this->sourceSecurityGroupName = $sourceSecurityGroupName;
    }

    /**
     * @param mixed $sourceSecurityGroupOwnerId
     * [nondefault VPC] The AWS account ID that owns the source security group.
     * You can't specify this property with an IP address range.
     *
     * If you specify SourceSecurityGroupName or SourceSecurityGroupId and that security group is owned by a different account than the account creating the stack, you must specify the SourceSecurityGroupOwnerId; otherwise, this property is optional.
     *
     * Required: Conditional
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setSourceSecurityGroupOwnerId($sourceSecurityGroupOwnerId): void
    {
        $this->sourceSecurityGroupOwnerId = $sourceSecurityGroupOwnerId;
    }

    /**
     * @param mixed $toPort
     * The end of port range for the TCP and UDP protocols, or an ICMP/ICMPv6 code.
     * A value of -1 indicates all ICMP/ICMPv6 codes for the specified ICMP type.
     * If you specify all ICMP/ICMPv6 types, you must specify all codes.
     *
     * Use this for ICMP and any protocol that uses ports.
     *
     * Required: No
     *
     * Type: Integer
     *
     * Update requires: Replacement
     */
    public function setToPort($toPort): void
    {
        $this->toPort = $toPort;
    }

    public function getSecurityGroupIngress()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "CidrIp", $this->cidrIp);
        $properties = $this->conditionalAdd($properties, "CidrIpv6", $this->cidrIpv6);
        $properties = $this->conditionalAdd($properties, "Description", $this->description);
        $properties = $this->conditionalAdd($properties, "FromPort", $this->fromPort);
        $properties = $this->conditionalAdd($properties, "GroupId", $this->groupId);
        $properties = $this->conditionalAdd($properties, "GroupName", $this->groupName);
        $properties["IpProtocol"] = $this->ipProtocol;
        $properties = $this->conditionalAdd($properties, "SourcePrefixListId", $this->sourcePrefixListId);
        $properties = $this->conditionalAdd($properties, "SourceSecurityGroupId", $this->sourceSecurityGroupId);
        $properties = $this->conditionalAdd($properties, "SourceSecurityGroupName", $this->sourceSecurityGroupName);
        $properties = $this->conditionalAdd($properties, "SourceSecurityGroupOwnerId", $this->sourceSecurityGroupOwnerId);
        $properties = $this->conditionalAdd($properties, "ToPort", $this->toPort);
        return [
            "Type" => "AWS::EC2::SecurityGroupIngress",
            "Properties" => $properties
        ];
    }

    public function getEmbeddedSecurityGroupIngress()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "CidrIp", $this->cidrIp);
        $properties = $this->conditionalAdd($properties, "CidrIpv6", $this->cidrIpv6);
        $properties = $this->conditionalAdd($properties, "Description", $this->description);
        $properties = $this->conditionalAdd($properties, "FromPort", $this->fromPort);
        $properties = $this->conditionalAdd($properties, "GroupId", $this->groupId);
        $properties = $this->conditionalAdd($properties, "GroupName", $this->groupName);
        $properties["IpProtocol"] = $this->ipProtocol;
        $properties = $this->conditionalAdd($properties, "SourcePrefixListId", $this->sourcePrefixListId);
        $properties = $this->conditionalAdd($properties, "SourceSecurityGroupId", $this->sourceSecurityGroupId);
        $properties = $this->conditionalAdd($properties, "SourceSecurityGroupName", $this->sourceSecurityGroupName);
        $properties = $this->conditionalAdd($properties, "SourceSecurityGroupOwnerId", $this->sourceSecurityGroupOwnerId);
        $properties = $this->conditionalAdd($properties, "ToPort", $this->toPort);
        return $properties;
    }


}