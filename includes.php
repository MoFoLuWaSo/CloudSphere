<?php

//Utils
include('Utils/AWSTypes.php');
include('Utils/ConditionalAdd.php');
include('Utils/Config.php');
include('Utils/Service.php');
include('Utils/Package.php');
include('Utils/Commands.php');
include('Utils/File.php');
include('Utils/Group.php');
include('Utils/Joins.php');
include('Utils/User.php');
include('Utils/Base64.php');

//Formation
include('Formation/Template.php');
include('Formation/Parameter.php');
include('Formation/Metadata.php');
include('Formation/Outputs.php');
include('Formation/Resource.php');


//Resources EC2
include('Resources/EC2/CpuOptions.php');
include('Resources/EC2/Instance.php');
include('Resources/EC2/InternetGateway.php');
include('Resources/EC2/Route.php');
include('Resources/EC2/RouteTable.php');
include('Resources/EC2/SecurityGroup.php');
include('Resources/EC2/SecurityGroupEgress.php');
include('Resources/EC2/SecurityGroupIngress.php');
include('Resources/EC2/Subnet.php');
include('Resources/EC2/SubnetRouteTableAssociation.php');
include('Resources/EC2/VPC.php');
include('Resources/EC2/VPCGatewayAttachment.php');

//Resources Elastic Load Balancing
include('Resources/ElasticLoadBalancing/Listener.php');
include('Resources/ElasticLoadBalancing/LoadBalancer.php');
include('Resources/ElasticLoadBalancing/TargetGroup.php');


//Resources IAM
include('Resources/IAM/InstanceProfile.php');
include('Resources/IAM/PolicyDocument.php');
include('Resources/IAM/Role.php');
include('Resources/IAM/Statement.php');

//Resources AutoScaling
include('Resources/AutoScaling/AutoScalingGroup.php');
include('Resources/AutoScaling/LaunchConfiguration.php');
include('Resources/AutoScaling/ScalingPolicy.php');

//Resources RDS
include('Resources/RDS/DbInstance.php');
//Resources CloudWatch
include('Resources/CloudWatch/Alarm.php');

//Metadata
include('MetaData/CloudFormation/Init.php');



