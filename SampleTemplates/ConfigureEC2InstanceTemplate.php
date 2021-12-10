<?php

include('includes.php');

use Formation\Outputs;
use Formation\Parameter;
use Formation\Template;
use Resources\EC2\Instance;
use Resources\EC2\SecurityGroup;
use Resources\EC2\SecurityGroupIngress;
use Utils\Joins;

class ConfigureEC2InstanceTemplate
{


    public function createTemplate()
    {
        $template = new Template();

        $template->addDescription("My new hellow world");

        $keyPair = "KeyPair";
        $template->addParameter($keyPair, $this->createKeyPairParameters());

        $imageId = "ImageId";
        $template->addParameter($imageId, $this->createImageParameter());

        $securityGroupName = "webSecurityGroup";
        $template->addResources($securityGroupName, $this->createSecurityGroups());

        $instanceName = "webInstance";
        $template->addResources($instanceName, $this->createInstance($keyPair, $securityGroupName, $imageId));

        $outputs = $this->createOutputs($instanceName);
        $template->addOutputs($outputs[0]);
        $template->addOutputs($outputs[1]);
        //$template->addOutputs($outputs[2]);

        $template->generateTemplate("ec2Instance");

    }

    public function createKeyPairParameters()
    {
        $parameter = new Parameter(EC2KeyPairKeyName);
        $parameter->setConstraintDescription("Select or Enter Your KeyPair Value");
        return $parameter;
    }

    public function createImageParameter()
    {
        $parameter = new Parameter(EC2ImageId);
        $parameter->setConstraintDescription("Enter EC2 Image ID");
        return $parameter;
    }

    public function createSecurityGroups()
    {
        $securityGroup = new SecurityGroup("Allow TCP and SSH on port 80 and 22");
        //tcp for inbound coming from public
        $inbound = new SecurityGroupIngress("tcp");

        $inbound->setToPort("80");
        $inbound->setFromPort("80");
        $inbound->setCidrIp("0.0.0.0/0");
        $publicAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $inbound->setToPort("22");
        $inbound->setFromPort("22");
        $sshAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $securityGroup->setSecurityGroupIngress([$sshAccess, $publicAccess]);
        return $securityGroup;

    }

    public function createOutputs($instanceName)
    {
        $publicIpOutputs = new Outputs("InstancePublicIp");
        $publicIpOutputs->setDescription("Public Ip of new Instance");
        $publicIpOutputs->setValue(["Fn::GetAtt" => [$instanceName, "PublicIp"]]);

//        $stackNameOutputs = new Outputs("InstanceStackName");
//        $stackNameOutputs->setDescription("Stack name of the cloud formation");
//        $stackNameOutputs->setValue(["Fn::GetAtt" => [$instanceName, "AWS::StackName"]]);


        // $join = new Joins();
        //  $join->addLine("http://");
        //$join->addLine(["Fn::GetAtt" => [$instanceName, "PublicDnsName"]]);
        $webUrlOutputs = new Outputs("InstanceWebUrl");
        $webUrlOutputs->setDescription("Application end point");
        $webUrlOutputs->setValue(["Fn::GetAtt" => [$instanceName, "PublicDnsName"]]);
        //  $webUrlOutputs->setValue($join->getJoin());
        return [$webUrlOutputs, $publicIpOutputs];
    }

    public function createInstance($keyPair, $securityGroupName, $imageId)
    {
        $ecs = new Instance();
        $ecs->setImageId(["Ref" => $imageId]);
        $ecs->setKeyName(["Ref" => $keyPair]);
        $ecs->setSecurityGroups(["Ref" => $securityGroupName]);
        $ecs->setInstanceType("t2.micro");
        $ecs->setTags([["Key"=>"ec2","Value"=>"ec2Host"]]);
        return $ecs;
    }
}

$newTemplate = new ConfigureEC2InstanceTemplate();
$newTemplate->createTemplate();