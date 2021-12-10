<?php


namespace Resources\EC2;




use Utils\ConditionalAdd;

class SecurityGroupEgress extends ConditionalAdd
{
    private $cidrIp;
    private $cidrIpv6;
    private $description;
    private $destinationPrefixListId;
    private $destinationSecurityGroupId;
    private $fromPort;
    private $groupId;

    private $ipProtocol;
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
     * You must specify a destination security group (DestinationPrefixListId or DestinationSecurityGroupId) or a CIDR range (CidrIp or CidrIpv6).
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
     * You must specify a destination security group (DestinationPrefixListId or DestinationSecurityGroupId) or a CIDR range (CidrIp or CidrIpv6).
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
     *The description of an egress (outbound) security group rule.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: No interruption
     *
     * Update requires: No interruption
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $fromPort
     * The start of port range for the TCP and UDP protocols, or an ICMP/ICMPv6 type number. A value of -1 indicates all ICMP/ICMPv6 types. If you specify all ICMP/ICMPv6 types, you must specify all codes.
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
     * The ID of the security group. You must specify either the security group ID or the security group name in the request. For security groups in a nondefault VPC, you must specify the security group ID.
     *
     * Required: Yes
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
     * @param mixed $ipProtocol
     * The IP protocol name (tcp, udp, icmp, icmpv6) or number (see Protocol Numbers).
     *
     * [VPC only] Use -1 to specify all protocols. When authorizing security group rules, specifying -1 or a protocol number other than tcp, udp, icmp, or icmpv6 allows traffic on all ports, regardless of any port range you specify. For tcp, udp, and icmp, you must specify a port range. For icmpv6, the port range is optional; if you omit the port range, traffic for all types and codes is allowed.
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
     * @param mixed $destinationPrefixListId
     * [EC2-VPC only] The prefix list IDs for an AWS service. This is the AWS service that you want to access through a VPC endpoint from instances associated with the security group.
     *
     * You must specify a destination security group (DestinationPrefixListId or DestinationSecurityGroupId) or a CIDR range (CidrIp or CidrIpv6).
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setDestinationPrefixListId($destinationPrefixListId): void
    {
        $this->destinationPrefixListId = $destinationPrefixListId;
    }

    /**
     * @param mixed $destinationSecurityGroupId
     * The ID of the security group.
     *
     * You must specify a destination security group (DestinationPrefixListId or DestinationSecurityGroupId) or a CIDR range (CidrIp or CidrIpv6).
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setDestinationSecurityGroupId($destinationSecurityGroupId): void
    {
        $this->destinationSecurityGroupId = $destinationSecurityGroupId;
    }


    /**
     * @param mixed $toPort
     * The end of port range for the TCP and UDP protocols, or an ICMP/ICMPv6 code. A value of -1 indicates all ICMP/ICMPv6 codes. If you specify all ICMP/ICMPv6 types, you must specify all codes.
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

    public function getSecurityGroupEgress()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "CidrIp", $this->cidrIp);
        $properties = $this->conditionalAdd($properties, "CidrIpv6", $this->cidrIpv6);
        $properties = $this->conditionalAdd($properties, "Description", $this->description);
        $properties = $this->conditionalAdd($properties, "DestinationPrefixListId", $this->destinationPrefixListId);
        $properties = $this->conditionalAdd($properties, "DestinationSecurityGroupId", $this->destinationSecurityGroupId);
        $properties = $this->conditionalAdd($properties, "FromPort", $this->fromPort);
        $properties = $this->conditionalAdd($properties, "GroupId", $this->groupId);
        $properties["IpProtocol"] = $this->ipProtocol;

        $properties = $this->conditionalAdd($properties, "ToPort", $this->toPort);
        return [
            "Type" => "AWS::EC2::SecurityGroupEgress",
            "Properties" => $properties
        ];
    }

    public function getEmbeddedSecurityGroupEgress()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "CidrIp", $this->cidrIp);
        $properties = $this->conditionalAdd($properties, "CidrIpv6", $this->cidrIpv6);
        $properties = $this->conditionalAdd($properties, "Description", $this->description);
        $properties = $this->conditionalAdd($properties, "DestinationPrefixListId", $this->destinationPrefixListId);
        $properties = $this->conditionalAdd($properties, "DestinationSecurityGroupId", $this->destinationSecurityGroupId);
        $properties = $this->conditionalAdd($properties, "FromPort", $this->fromPort);
        $properties = $this->conditionalAdd($properties, "GroupId", $this->groupId);
        $properties["IpProtocol"] = $this->ipProtocol;
        $properties = $this->conditionalAdd($properties, "ToPort", $this->toPort);
        return $properties;
    }


}