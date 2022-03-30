<?php
/*
 * AWS Specific Types
 */
define("AutoScalingLaunchConfiguration", "AWS::AutoScaling::LaunchConfiguration");
define("AutoScalingAutoScalingGroup", "AWS::AutoScaling::AutoScalingGroup");
define("EC2AvailabilityZoneName", "AWS::EC2::AvailabilityZone::Name");
define("EC2ImageId", "AWS::EC2::Image::Id");
define("EC2InstanceId", "AWS::EC2::Instance::Id");
define("EC2KeyPairKeyName", "AWS::EC2::KeyPair::KeyName");
define("EC2SecurityGroupGroupName", "AWS::EC2::SecurityGroup::GroupName");
define("EC2SecurityGroupId", "AWS::EC2::SecurityGroup::Id");
define("EC2SubnetId", "AWS::EC2::Subnet::Id");
define("EC2Subnet", "AWS::EC2::Subnet");
define("EC2SubnetRouteTableAssociation", "AWS::EC2::SubnetRouteTableAssociation");
define("EC2RouteTable", "AWS::EC2::RouteTable");
define("EC2Route", "AWS::EC2::Route");
define("EC2VPCId", "AWS::EC2::VPC::Id");
define("EC2VPC", "AWS::EC2::VPC");
define("EC2InternetGateway", "AWS::EC2::InternetGateway");
define("EC2VPCGatewayAttachment", "AWS::EC2::VPCGatewayAttachment");
define("ElasticLoadBalancingV2TargetGroup", "AWS::ElasticLoadBalancingV2::TargetGroup");
define("ElasticLoadBalancingV2Listener", "AWS::ElasticLoadBalancingV2::Listener");
define("ElasticLoadBalancingV2LoadBalancer", "AWS::ElasticLoadBalancingV2::LoadBalancer");
define("RDSDBInstance", "AWS::RDS::DBInstance");
define("Route53HostedZoneId", "AWS::Route53::HostedZone::Id");
define("ListEC2AvailabilityZoneName", "List<AWS::EC2::AvailabilityZone::Name>");
define("ListEC2ImageId", "List<AWS::EC2::Image::Id>");
define("ListEC2InstanceId", "List<AWS::EC2::Instance::Id>");
define("ListEC2SecurityGroupGroupName", "List<AWS::EC2::SecurityGroup::GroupName>");
define("ListEC2SecurityGroupId", "List<AWS::EC2::SecurityGroup::Id>");
define("ListEC2SubnetId", "List<AWS::EC2::Subnet::Id>");
define("ListEC2VPCId", "List<AWS::EC2::VPC::Id>");
define("ListRoute53HostedZoneId", "List<AWS::Route53::HostedZone::Id>");

/*
 * SSM PARAMETER TYPES
 */
define("SSMParameterName", "AWS::SSM::Parameter::Name");


/*
 * METADATA KEYS
 */
define("CloudFormationInit", "AWS::CloudFormation::Init");


/*
 * Actions
 *
 */
define("AssumedRole", "sts:AssumeRole");
