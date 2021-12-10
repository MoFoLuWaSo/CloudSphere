<?php
/*
 * AWS Specific Types
 */
define("EC2AvailabilityZoneName", "AWS::EC2::AvailabilityZone::Name");
define("EC2ImageId", "AWS::EC2::Image::Id");
define("EC2InstanceId", "AWS::EC2::Instance::Id");
define("EC2KeyPairKeyName", "AWS::EC2::KeyPair::KeyName");
define("EC2SecurityGroupGroupName", "AWS::EC2::SecurityGroup::GroupName");
define("EC2SecurityGroupId", "AWS::EC2::SecurityGroup::Id");
define("EC2SubnetId", "AWS::EC2::Subnet::Id");
define("EC2VPCId", "AWS::EC2::VPC::Id");
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
