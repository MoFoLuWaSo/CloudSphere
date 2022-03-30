<?php

use Formation\Outputs;
use Formation\Parameter;
use Formation\Template;
use Resources\EC2\Instance;
use Resources\EC2\SecurityGroup;
use Resources\EC2\SecurityGroupIngress;
use Utils\Base64;
use Utils\Joins;

include("includes.php");

class WelcomeTemplate
{
    public function createTemplate()
    {
        $template = new Template();

        //create KeyPair parameter
        $keyPair = "KeyPair";
        $template->addParameter($keyPair, $this->createKeyPair());

        //Create Image parameter
        $imageId = "ImageId";
        $template->addParameter($imageId, $this->createImage());

        //Create Security Group
        $securityGroupName = "DevOpsGroup";
        $template->addResources($securityGroupName, $this->createSecurityGroup());

        //create user data
        $userData = $this->createUserData();

        //create instance
        $instanceName = "DevInstance";
        $template->addResources($instanceName, $this->createInstance($keyPair, $imageId, $securityGroupName, $userData));

        //create output
        $output = $this->createOutput($instanceName);

        $template->addOutputs($output[0]);
        $template->addOutputs($output[1]);

        $template->generateTemplate("welcomeTemplate");
    }

    public function createKeyPair()
    {
        $parameter = new Parameter(EC2KeyPairKeyName);
        $parameter->setConstraintDescription("Select Instance Key Pair");
        return $parameter;
    }

    public function createImage()
    {
        $parameter = new Parameter(EC2ImageId);
        $parameter->setConstraintDescription("Enter Image ID");
        return $parameter;

    }

    public function createSecurityGroup()
    {
        $securityGroup = new SecurityGroup("Allow tcp and ssh access on port 80 and 22");
        $inbound = new SecurityGroupIngress("tcp");

        //Inbound for ssh access
        $inbound->setToPort("22");
        $inbound->setFromPort("22");
        $inbound->setCidrIp("0.0.0.0/0");
        $sshAccess = $inbound->getEmbeddedSecurityGroupIngress();

        //inbound for public access
        $inbound->setFromPort("80");
        $inbound->setToPort("80");
        $publicAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $securityGroup->setSecurityGroupIngress([$sshAccess, $publicAccess]);
        return $securityGroup;


    }

    public function createUserData()
    {
        $joins = new Joins("\n");
        //initialize bin bash
        $joins->addLine("#!/bin/bash -xe ");

        //--Install apache
        $joins->addLine("sudo yum install httpd -y ");
        $joins->addLine("sudo systemctl start httpd ");
        $joins->addLine("sudo systemctl enable httpd.service ");

        //--Install Php
        $joins->addLine("sudo amazon-linux-extras install epel -y ");
        $joins->addLine("sudo amazon-linux-extras install php7.4 -y ");
        $joins->addLine("sudo yum install epel-release yum-utils -y ");
        $joins->addLine("sudo yum -y update ");

        //--install php extensions
        $joins->addLine("sudo yum install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip php-gd php-pdo_pgsql --skip-broken -y ");
        $joins->addLine("sudo systemctl  restart httpd.service ");

        //--install git
        $joins->addLine("sudo yum install git -y ");

        //--install composer
        $joins->addLine("sudo yum install php-cli php-zip wget unzip -y ");
        $joins->addLine("sudo curl -sS https://getcomposer.org/installer | sudo php ");
        $joins->addLine("sudo mv composer.phar /usr/local/bin/composer ");
        $joins->addLine("sudo ln -s /usr/local/bin/composer /usr/bin/composer ");

        //--Install nodejs
        $joins->addLine("curl -sL https://rpm.nodesource.com/setup_16.x | sudo bash - ");
        $joins->addLine("sudo yum install nodejs -y ");

        //clone DevOps Project Git repos
        $joins->addLine("cd /var/www/html ");
        $joins->addLine("sudo git clone https://github.com/MoFoLuWaSo/DevOpsProject.git ");
        $joins->addLine("cd /var/www/html/DevOpsProject ");

        //set rights and permissions
        $joins->addLine("sudo chown -R \$USER:\$USER /var/www/html/DevOpsProject ");
        $joins->addLine("sudo chmod -R 755 /var/www ");

        //install composer packages
        $joins->addLine("sudo composer install ");
        $joins->addLine("sudo chmod -R 777 /var/www/html/DevOpsProject/storage ");

        //create env file and generate application key
        $joins->addLine("cp .env.example .env ");
        $joins->addLine("php artisan key:gen ");

        //create virtual hosts to remove public from laravel path
        $joins->addLine("sudo chmod 777 /etc/httpd/conf.d/welcome.conf ");
        $joins->addLine("sudo echo 
        \"<VirtualHost *:80>
            
            DocumentRoot /var/www/html/DevOpsProject/public
        
            <Directory /var/www/html/DevOpsProject>
                AllowOverride All
            </Directory>
        </VirtualHost>\" > /etc/httpd/conf.d/welcome.conf ");

        //restart apache
        $joins->addLine("sudo systemctl restart httpd.service ");

        return $joins->getJoin();


    }

    public function createInstance($keyPair, $imageId, $securityGroup, $userData)
    {
        $ec2 = new Instance();
        $ec2->setKeyName(["Ref" => $keyPair]);
        $ec2->setImageId(["Ref" => $imageId]);
        $ec2->setSecurityGroups(["Ref" => $securityGroup]);
        $ec2->setInstanceType("t2.micro");
        $ec2->setTags([["Key" => "Name", "Value" => "DevOpsInstance"]]);
        $ec2->setUserData(Base64::convertToBase($userData));
        return $ec2;

    }

    public function createOutput($instanceName)
    {
        //output for instance public ip
        $publicIp = new Outputs("InstancePublicIp");
        $publicIp->setDescription("Public ip of the instance");
        $publicIp->setValue(["Fn::GetAtt" => [$instanceName, "PublicIp"]]);

        //output for web url
        $webUrl = new Outputs("InstanceWebUrl");
        $webUrl->setDescription("Web url (Public dns name of the instance");
        $webUrl->setValue(["Fn::GetAtt" => [$instanceName, "PublicDnsName"]]);

        return [$webUrl, $publicIp];


    }


}

$welcome = new WelcomeTemplate();
$welcome->createTemplate();