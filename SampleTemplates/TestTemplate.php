<?php

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
use Utils\Base64;
use Utils\Joins;

include('includes.php');


class TestTemplate
{
    public function createTemplate()
    {
        $template = new Template();

        $keyPair = "KeyPair";
        $template->addParameter($keyPair, $this->createKeyPairParameter());

        $imageId = "ImageId";
        $template->addParameter($imageId, $this->createImageParameter());

        $securityGroupName = "DevOpsGroup";
        $template->addResources($securityGroupName, $this->createSecurityGroups());



        $userData = $this->createUserData();


        $instanceName = "webInstance";
        $template->addResources($instanceName, $this->createInstance($keyPair, $securityGroupName, $imageId, $userData));

        $output = $this->createOutputs($instanceName);
        $template->addOutputs($output[0]);
        $template->addOutputs($output[1]);

        $template->generateTemplate("welcomeTemplate");
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

    public function createKeyPairParameter()
    {
        $parameter = new Parameter(EC2KeyPairKeyName);
        $parameter->setConstraintDescription("Select your key pair value");
        return $parameter;
    }

    public function createImageParameter()
    {
        $parameter = new Parameter(EC2ImageId);
        $parameter->setConstraintDescription("Enter image id ");
        return $parameter;
    }

    public function createSecurityGroups()
    {
        $securityGroup = new SecurityGroup("Allow TCP and SSH on port 80 and 22");

        $inbound = new SecurityGroupIngress("tcp");
        $inbound->setFromPort("80");
        $inbound->setToPort("80");
        $inbound->setCidrIp("0.0.0.0/0");
        $publicAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $inbound->setFromPort("22");
        $inbound->setToPort("22");
        $sshAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $securityGroup->setSecurityGroupIngress([$publicAccess, $sshAccess]);

        return $securityGroup;
    }

    public function createUserData()
    {


        $joins = new Joins("\n");
        $joins->addLine("#!/bin/bash -xe ");
        //Install apache
        $joins->addLine("yum install httpd -y");
        $joins->addLine("sudo systemctl start httpd");
        $joins->addLine("sudo systemctl enable httpd.service");

        //install php
        $joins->addLine("sudo amazon-linux-extras install epel -y ");
        $joins->addLine("sudo amazon-linux-extras install php7.4 -y ");
        $joins->addLine("sudo yum install epel-release yum-utils -y ");
        $joins->addLine("sudo yum -y update ");
        $joins->addLine("sudo yum install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip php-gd php-pdo_pgsql -y --skip-broken ");
        $joins->addLine("sudo systemctl restart httpd.service ");

        //install git
        $joins->addLine("sudo yum install git -y ");
        //install composer
        $joins->addLine("sudo yum install php-cli php-zip wget unzip -y ");


        $joins->addLine("sudo curl -sS https://getcomposer.org/installer | sudo php ");
        $joins->addLine("sudo mv composer.phar /usr/local/bin/composer ");
        $joins->addLine("sudo ln -s /usr/local/bin/composer /usr/bin/composer ");


        //install nodejs
        $joins->addLine("curl -sL https://rpm.nodesource.com/setup_16.x | sudo bash - ");
        $joins->addLine("sudo yum install nodejs -y ");

        $joins->addLine("cd /var/www/html ");
        $joins->addLine("sudo git clone https://github.com/MoFoLuWaSo/DevOpsProject.git ");
        $joins->addLine("cd /var/www/html/DevOpsProject ");
        $joins->addLine("sudo chown -R \$USER:\$USER /var/www/html/DevOpsProject ");
        $joins->addLine("sudo chmod -R 755 /var/www ");

        $joins->addLine("sudo composer install ");
        $joins->addLine("sudo chmod -R 777 /var/www/html/DevOpsProject/storage ");
        $joins->addLine("cp .env.example .env ");
        $joins->addLine("php artisan key:gen ");
        $joins->addLine("sudo chmod 777 /etc/httpd/conf.d/welcome.conf ");
        $joins->addLine("sudo echo \"<VirtualHost *:80>
    
    DocumentRoot /var/www/html/DevOpsProject/public

    <Directory /var/www/html/DevOpsProject>
        AllowOverride All
    </Directory>
</VirtualHost> > /etc/httpd/conf.d/welcome.conf \" ");
        $joins->addLine("sudo systemctl restart httpd.service ");

        return $joins->getJoin();

    }

    public function createInstance($keyPair, $securityGroupName, $imageId, $userData)
    {
        $ec2 = new Instance();
        $ec2->setKeyName(["Ref" => $keyPair]);
        $ec2->setImageId(["Ref" => $imageId]);
        $ec2->setSecurityGroups(["Ref" => $securityGroupName]);
        $ec2->setInstanceType("t2.micro");
        $ec2->setTags([["Key" => "Name", "Value" => "DevOpsInstance"]]);
        $ec2->setUserData(Base64::convertToBase($userData));
        return $ec2;
    }

    public function createOutputs($instanceName)
    {
        $publicIpOutputs = new Outputs("InstancePublicIp");
        $publicIpOutputs->setDescription("Public Ip of new Instance");
        $publicIpOutputs->setValue(["Fn::GetAtt" => [$instanceName, "PublicIp"]]);

        $webUrlOutputs = new Outputs("InstanceWebUrl");
        $webUrlOutputs->setDescription("Application end point");
        $webUrlOutputs->setValue(["Fn::GetAtt" => [$instanceName, "PublicDnsName"]]);

        return [$webUrlOutputs, $publicIpOutputs];
    }

    public function createInstanceProfile($roleName)
    {
        $profile = new InstanceProfile([["Ref" => $roleName]]);
        $profile->setPath("/");
        return $profile;
    }


}

$instance = new TestTemplate();
$instance->createTemplate();