<?php

include('includes.php');
use Formation\Outputs;
use Formation\Parameter;
use Formation\Template;
use Resources\EC2\Instance;
use Resources\EC2\SecurityGroup;
use Resources\EC2\SecurityGroupIngress;
use Resources\IAM\InstanceProfile;
use Resources\IAM\PolicyDocument;
use Resources\IAM\Role;
use Resources\IAM\Statement;

class JenkinsEC2Instance
{
    public function createTemplate()
    {
        $template = new Template();

        $template->addDescription("Jenkins ");

        $keyPair = "KeyPair";
        $template->addParameter($keyPair, $this->createKeyPairParameters());

        $imageId = "ImageId";
        $template->addParameter($imageId, $this->createImageParameter());

        $roleName = "Role";
        $template->addResources($roleName, $this->createRole());

        $instanceProfile = "InstanceProfile";
        $template->addResources($instanceProfile, $this->createInstanceProfile($roleName));


        $securityGroupName = "webSecurityGroup";
        $template->addResources($securityGroupName, $this->createSecurityGroups());

        $instanceName = "webInstance";
        $template->addResources($instanceName, $this->createInstance($keyPair, $securityGroupName, $imageId,$instanceProfile));

        $outputs = $this->createOutputs($instanceName);
        $template->addOutputs($outputs[0]);
        $template->addOutputs($outputs[1]);
        //$template->addOutputs($outputs[2]);

        $template->generateTemplate("jenkinsInstance");

    }

    public function createRole()
    {
        $statement = new Statement();
        $statement->setEffect("Allow");
        $statement->setAction(AssumedRole);
        $statement->setPrincipal(["Service" => ["ec2.amazonaws.com"]]);
        $statement->setStatement($statement);
        $policy = new PolicyDocument($statement);
        return new Role($policy);
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
        $securityGroup = new SecurityGroup("Allow TCP and SSH on port 80,8080 and 22");
        //tcp for inbound coming from public
        $inbound = new SecurityGroupIngress("tcp");

        $inbound->setToPort("80");
        $inbound->setFromPort("80");
        $inbound->setCidrIp("0.0.0.0/0");
        $publicAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $inbound->setToPort("22");
        $inbound->setFromPort("22");
        $sshAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $inbound->setToPort("8080");
        $inbound->setFromPort("8080");
        $jenkinsAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $securityGroup->setSecurityGroupIngress([$sshAccess, $publicAccess, $jenkinsAccess]);
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

    public function createInstanceProfile($roleName)
    {
        $profile = new InstanceProfile([["Ref" => $roleName]]);
        $profile->setPath("/");
        return $profile;
    }

    public function createInstance($keyPair, $securityGroupName, $imageId,$instanceProfile)
    {
        $ecs = new Instance();
        $ecs->setImageId(["Ref" => $imageId]);
        $ecs->setKeyName(["Ref" => $keyPair]);
        $ecs->setSecurityGroups(["Ref" => $securityGroupName]);
        $ecs->setInstanceType("t2.micro");
        $ecs->setTags([["Key" => "jenkins", "Value" => "jenkinsHost"]]);
        $ecs->setIamInstanceProfile(["Ref" => $instanceProfile]);
        return $ecs;
    }

}


$jenkins = new JenkinsEC2Instance();
$jenkins->createTemplate();