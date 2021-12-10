<?php

use Formation\Metadata;
use Formation\Outputs;
use Formation\Parameter;
use Formation\Template;
use MetaData\CloudFormation\Init;
use Resources\EC2\Instance;
use Resources\EC2\SecurityGroup;
use Resources\EC2\SecurityGroupIngress;
use Utils\Base64;
use Utils\Config;
use Utils\Joins;
use Utils\Package;
use Utils\Service;

include('includes.php');


function generateHelloWorldInstance()
{

    $template = new Template();
    $template->addDescription("Sample hello world application");

    //create key pair parameters
    $keyPair = new Parameter(EC2KeyPairKeyName);
    $keyPair->setConstraintDescription("Must be the name of an existing EC2 KeyPair");
    $template->addParameter("KeyPair", $keyPair);
    //create vpc parameters
    // $vpcId = new Parameter(EC2VPCId);
    //$vpcId->setConstraintDescription("VPC ID of the current server");
    // $template->addParameter("VpcId", $vpcId->getParameters());
    //create security groups
    $securityGroup = new SecurityGroup("Allow SSH and TCP on port 80");
    // $securityGroup->setVpcId(["Ref" => "VpcId"]);
    $sshInbound = new SecurityGroupIngress("tcp");

    $sshInbound->setFromPort("22");
    $sshInbound->setToPort("22");
    //$sshInbound->setCidrIp(["Ref"=>"myIp"]);
    $sshInbound->setCidrIp("0.0.0.0/0");
    $inbound1 = $sshInbound->getEmbeddedSecurityGroupIngress();
    $sshInbound->setFromPort("80");
    $sshInbound->setToPort("80");
    $inbound2 = $sshInbound->getEmbeddedSecurityGroupIngress();
    $securityGroup->setSecurityGroupIngress([$inbound1, $inbound2]);
    //add security group to resources
    $template->addResources("webSecurityGroup", $securityGroup);
    //create ec2 instance and add to resources
    $ecs = new Instance();
    $ecs->setImageId("ami-013a129d325529d4d");
    $ecs->setInstanceType("t2.micro");
    $ecs->setSecurityGroups(["Ref" => "webSecurityGroup"]);
    $ecs->setKeyName(["Ref" => "KeyPair"]);

    $myIp = new Parameter("String");
    $myIp->setDescription("Enter the CIDR IP to secure your account");
    $myIp->setConstraintDescription("The CIDR ip to secure ssh");
    $template->addParameter("myIp", $myIp);

    //    $joins->addLine("yum install -y aws-cfn-bootstrap\n");
    //    $joins->addLine("# Install the files and packages from the metadata\n");
    //    $joins->addLine("/opt/aws/bin/cfn-init -v ");
    //    $joins->addLine("         --stack ");
    //    $joins->addLine(["Ref" => "AWS::StackName"]);
    //    $joins->addLine("         --resource webInstance");
    //    $joins->addLine("         --configsets Install ");
    //    $joins->addLine("         --region ");
    //    $joins->addLine(["Ref" => "AWS::Region"]);
    //    $joins->addLine("\n");
    //    $joins->addLine("# Signal the status from cfn-init\n");
    //    $joins->addLine("/opt/aws/bin/cfn-signal -e $? ");
    //    $joins->addLine("         --stack ");
    //    $joins->addLine(["Ref" => "AWS::StackName"]);
    //    $joins->addLine("         --resource webInstance ");
    //
    //    $joins->addLine("         --region ");
    //    $joins->addLine(["Ref" => "AWS::Region"]);
    //    $joins->addLine("\n");
    $joins = new Joins("\n");
    $joins->addLine("#!/bin/bash -xe ");
    $joins->addLine("yum update -y ");
    $joins->addLine("yum install -y httpd ");
    $joins->addLine("sudo systemctl start httpd ");
    $joins->addLine("sudo systemctl enable httpd.service ");
    $joins->addLine("sudo wget https://home.phillipsoutsourcing.net/index.html -O /var/www/html/index.html");
    $ecs->setUserData(Base64::convertToBase($joins->getJoin()));

    //set metadata to install apache and start it
    // $metadata = new Metadata();
    // $metadata->addInfo("Comment", "Install Apache and upload test file");
    // $init = new Init();
    // $init->setConfigSets("Install", ["Install"]);
    // $config = new Config();
    // $package = new Package();
    // $package->setYum(["httpd" => []]);
    // $service = new Service("httpd");
    // $service->setEnabled(true);
    // $service->setEnsureRunning(true);
    // $config->setPackages($package);
    // $config->setServices($service);
    // $init->setConfiguration("Install", $config);
    // $metadata->addInit($init);
    // $template->setMetadata($metadata);
    // $ecs->setSecurityGroupIds([[ "Fn::GetAtt" => [ "webSecurityGroup", "GroupId" ] ]]);

    $ec2Instance = $ecs->getInstance();
    //$ec2Instance['CreationPolicy'] = $ecs->getDefaultCreationPolicy();

    $template->addResources("webInstance", $ecs);
    $publicIpOutput = new Outputs("InstancePublicIp");
    $publicIpOutput->setDescription("Public Ip of our instance");
    $publicIpOutput->setValue(["Fn::GetAtt" => ["webInstance", "PublicIp"]]);
    $webUrlOutput = new Outputs("WebUrl");
    $webUrlOutput->setDescription("Application end point");
    $joinValue = new Joins();
    $joinValue->addLine("http://");
    $joinValue->addLine(["Fn::GetAtt" => ["webInstance", "PublicDnsName"]]);
    $webUrlOutput->setValue($joinValue->getJoin());
    $template->addOutputs($publicIpOutput);
    $template->addOutputs($webUrlOutput);
    echo $template->generateTemplate("HelloWorldInstanceSample");
}


generateHelloWorldInstance();