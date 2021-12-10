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
include('Resources/EC2/SecurityGroup.php');
include('Resources/EC2/SecurityGroupEgress.php');
include('Resources/EC2/SecurityGroupIngress.php');

//Resources IAM
include('Resources/IAM/InstanceProfile.php');
include('Resources/IAM/PolicyDocument.php');
include('Resources/IAM/Role.php');
include('Resources/IAM/Statement.php');

//Metadata
include('MetaData/CloudFormation/Init.php');



