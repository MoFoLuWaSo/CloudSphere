<?php


use Formation\Outputs;
use Formation\Parameter;
use Formation\Template;

;

use Resources\AutoScaling\AutoScalingGroup;
use Resources\AutoScaling\LaunchConfiguration;
use Resources\AutoScaling\ScalingPolicy;
use Resources\CloudWatch\Alarm;
use Resources\EC2\InternetGateway;


use Resources\EC2\Route;
use Resources\EC2\RouteTable;
use Resources\EC2\SecurityGroup;
use Resources\EC2\SecurityGroupIngress;
use Resources\EC2\Subnet;
use Resources\EC2\SubnetRouteTableAssociation;

use Resources\EC2\VPC;
use Resources\EC2\VPCGatewayAttachment;
use Resources\ElasticLoadBalancing\Listener;
use Resources\ElasticLoadBalancing\LoadBalancer;
use Resources\ElasticLoadBalancing\TargetGroup;
use Resources\RDS\DbInstance;
use Utils\Base64;
use Utils\Joins;

include("includes.php");

class Square1Deployments
{
    public function createTemplate()
    {
        $template = new Template();
        /*
         * Parameters
         */
        //create KeyPair parameter
        $keyPair = "KeyPair";
        $template->addParameter($keyPair, $this->createGeneralParameter("Select your Instance Key Pair", EC2KeyPairKeyName));

        //Create Image parameter
        $imageId = "ImageId";
        $template->addParameter($imageId, $this->createGeneralParameter("Enter only Amazon Linux EC2 Image ID", EC2ImageId));

        $gitHubUrl = "GitHubUrl";
        $github = $this->createGeneralParameter("Paste Github URL for the Square 1, Web Blog Repository");
        $github->setDefault("https://github.com/MoFoLuWaSo/square1-test.git");
        $template->addParameter($gitHubUrl, $github);


        //Create VPC CIDR parameter
        $vpcCidrID = "VpcCIDR";
        $template->addParameter($vpcCidrID, $this->createCidr("192.168.0.0/22", "Please enter the IP range (CIDR notation) for this VPC"));

        //Create PublicSubnet1 CIDR parameter
        $subnet1CidrId = "PublicSubnet1CIDR";
        $template->addParameter($subnet1CidrId, $this->createCidr("192.168.0.0/24", "Please enter the IP range (CIDR notation) for public subnet 1"));

        //Create PublicSubnet2 CIDR parameter
        $subnet2CidrId = "PublicSubnet2CIDR";
        $template->addParameter($subnet2CidrId, $this->createCidr("192.168.2.0/23", "Please enter the IP range (CIDR notation) for public subnet 2"));

        $dbName = "DBName";
        $template->addParameter($dbName, $this->createDbParameter("Enter a name for web blog database. Name must be alphanumeric", "webblogDB", false));

        $dbUsername = "DBUserName";
        $template->addParameter($dbUsername, $this->createDbParameter("Enter a username for your database. Name must be alphanumeric", "webblogDBUser", false));

        $dbPassword = "DBPassword";
        $template->addParameter($dbPassword, $this->createDbParameter("Enter a password for your database. Password must be alphanumeric", "webblogDBPass", true));


        /*
         * Resources
         */
        //Create VPC
        $vpcName = "WebBlogVPC";
        $template->addResources($vpcName, $this->createVPC($vpcCidrID, $vpcName));

        //Create Internet Gateway
        $igwName = "WebBlogIgw";
        $template->addResources($igwName, $this->createInternetGateway($igwName));

        //Create VPC Attachment
        $attachGateway = "AttachGateway";
        $template->addResources($attachGateway, $this->createVPCGatewayAttachment($vpcName, $igwName));

        //Create Public subnet 1
        $webBlogPublicSubnet1 = "WebBlogPublicSubnet1";
        $template->addResources($webBlogPublicSubnet1, $this->createSubnet($webBlogPublicSubnet1, $vpcName, $subnet1CidrId, "eu-central-1a", "a"));

        //Create Public subnet 2
        $webBlogPublicSubnet2 = "WebBlogPublicSubnet2";
        $template->addResources($webBlogPublicSubnet2, $this->createSubnet($webBlogPublicSubnet2, $vpcName, $subnet2CidrId, "eu-central-1b", "b"));

        //Create Public Route Table
        $routeTableName = "WebBlogRouteTable";
        $template->addResources($routeTableName, $this->createRouteTable($routeTableName, $vpcName));

        //Route the route table to the internet
        $webBlogRoute = "WebBlogPublicRoute";
        $template->addResources($webBlogRoute, $this->createRoute($routeTableName, $igwName));

        $subnet1routeTableAssociation = "WebBlogSubnetRouteTableAssociation1";
        $template->addResources($subnet1routeTableAssociation, $this->createSubnetRouteTableAssociation($webBlogPublicSubnet1, $routeTableName));

        $subnet2routeTableAssociation = "WebBlogSubnetRouteTableAssociation2";
        $template->addResources($subnet2routeTableAssociation, $this->createSubnetRouteTableAssociation($webBlogPublicSubnet2, $routeTableName));
        //Load balancer SG
        $loadBalancerSG = "LoadBalancerSG";
        $template->addResources($loadBalancerSG, $this->createLBSecurityGroup($vpcName));

        //EC2 Security Group
        $ec2SecurityGroup = "EC2SecurityGroup";
        $template->addResources($ec2SecurityGroup, $this->createEC2SecurityGroup($vpcName, $loadBalancerSG));


        //DB Security Group
        $dBSecurityGroup = "DBSecurityGroup";
        $template->addResources($dBSecurityGroup, $this->createDBSecurityGroup($vpcName, $ec2SecurityGroup));
        /*
        * Database section
        *
        */
        $subnetGroupName = "WebBlogSubnetGroup";
        $template->addResources($subnetGroupName, $this->createDBSubnetGroup($subnetGroupName, [$webBlogPublicSubnet1, $webBlogPublicSubnet2]));
        $dbIdentifier = "WebBlogDatabaseInstance";
        $template->addResources($dbIdentifier, $this->createDataBase($dbIdentifier, $dbName, $dbUsername, $dbPassword, $dBSecurityGroup, $subnetGroupName));


        //Create User data
        $userData = $this->createUserData($gitHubUrl, $dbName, $dbUsername, $dbPassword, $dbIdentifier);

        //create launch configuration
        $launchConfiguration = "WebBlogLaunchConfiguration";
        $template->addResources($launchConfiguration, $this->createLaunchConfiguration($imageId, $ec2SecurityGroup, $keyPair, $userData));

        //create target group
        $targetGroup = "WebBlogTargets";
        $template->addResources($targetGroup, $this->createTargetGroup($targetGroup, $vpcName));

        //create autoscaling group
        $autoScalingGroup = "WebBlogAutoScalingGroup";
        $template->addResources($autoScalingGroup, $this->createAutoScalingGroup($autoScalingGroup, [$webBlogPublicSubnet1, $webBlogPublicSubnet2], $launchConfiguration, $targetGroup));

        //create load balancer
        $loadBalancerName = "WebBlogLoadBalancer";
        $template->addResources($loadBalancerName, $this->createLoadBalancer($loadBalancerName, $loadBalancerSG, [$webBlogPublicSubnet1, $webBlogPublicSubnet2]));

        //create listener
        $loadBalancerListener = "WebBlogListener";
        $template->addResources($loadBalancerListener, $this->createLoadBalancerListener($loadBalancerName, $targetGroup));


        //create output
        $output = $this->createOutput($loadBalancerName, $dbIdentifier);

        $template->addOutputs($output[0]);
        $template->addOutputs($output[1]);

        $template->generateTemplate("WebBlogTemplate");
    }

    public function createVPC($vpcCidr, $vpcName)
    {
        return new VPC(array(
            "Type" => EC2VPC,
            "Properties" => [
                "CidrBlock" => ["Ref" => $vpcCidr],
                "EnableDnsSupport" => true,
                "InstanceTenancy" => "default",
                "EnableDnsHostnames" => true,
                "Tags" => [
                    ["Key" => "Name", "Value" => $vpcName]
                ]
            ]
        ));
    }

    public function createInternetGateway($igwName)
    {
        return new InternetGateway(array(
            "Type" => EC2InternetGateway,
            "Properties" => [
                "Tags" => [
                    ["Key" => "Name", "Value" => $igwName]
                ]
            ]
        ));
    }

    public function createVPCGatewayAttachment($vpcName, $igwName)
    {
        return new VPCGatewayAttachment(array(
            "Type" => EC2VPCGatewayAttachment,
            "Properties" => [
                "InternetGatewayId" => ["Ref" => $igwName],
                "VpcId" => ["Ref" => $vpcName],

            ]
        ));
    }

    public function createCidr($defaultIpRange, $description)
    {
        $parameter = new Parameter("String");
        $parameter->setDescription($description);
        $parameter->setDefault($defaultIpRange);

        return $parameter;
    }

    public function createSubnet($subnetName, $vpcName, $cidrBlock, $zone, $symbol)
    {

        return new Subnet(array(
            "Type" => EC2Subnet,
            "Properties" => [
                "VpcId" => ["Ref" => $vpcName],
                "CidrBlock" => ["Ref" => $cidrBlock],
                "AvailabilityZone" => $zone,
                "MapPublicIpOnLaunch" => true,
                "Tags" => [
                    ["Key" => "Name", "Value" => $subnetName . "" . $symbol]
                ]
            ]
        ));
    }

    public function createRouteTable($routeTableName, $vpcName)
    {
        return new RouteTable(array(
            "Type" => EC2RouteTable,
            "Properties" => [
                "VpcId" => ["Ref" => $vpcName],
                "Tags" => [
                    ["Key" => "Name", "Value" => $routeTableName]
                ]
            ]
        ));
    }

    public function createRoute($routeTableName, $internetGatewayName)
    {
        return new Route(array(
            "Type" => EC2Route,
            "Properties" => [
                "RouteTableId" => ["Ref" => $routeTableName],
                "DestinationCidrBlock" => "0.0.0.0/0",
                "GatewayId" => ["Ref" => $internetGatewayName],
            ]
        ));
    }

    public function createSubnetRouteTableAssociation($subnetName, $routeTableName)
    {
        return new SubnetRouteTableAssociation(array(
            "Type" => EC2SubnetRouteTableAssociation,
            "Properties" => [
                "SubnetId" => ["Ref" => $subnetName],
                "RouteTableId" => ["Ref" => $routeTableName],
            ]
        ));
    }

    public function createGeneralParameter($description, $type = "String")
    {
        $parameter = new Parameter($type);
        $parameter->setConstraintDescription($description);
        return $parameter;
    }

    public function createLBSecurityGroup($vpcName)
    {
        $securityGroup = new SecurityGroup("Allow tcp on port 80");
        $inbound = new SecurityGroupIngress("tcp");
        //inbound for public access
        $inbound->setFromPort("80");
        $inbound->setToPort("80");
        $inbound->setCidrIp("0.0.0.0/0");
        $securityGroup->setVpcId(["Ref" => $vpcName]);
        $publicAccess = $inbound->getEmbeddedSecurityGroupIngress();

        $securityGroup->setSecurityGroupIngress([$publicAccess]);
        $securityGroup->setTags([
            ["Key" => "Name", "Value" => "WebBlog Public Access"]
        ]);
        return $securityGroup;
    }

    public function createEC2SecurityGroup($vpcName, $loadBalancerSG)
    {
        $securityGroup = new SecurityGroup("Allow private tcp on port 80 and ssh on port 22");
        $inbound = new SecurityGroupIngress("tcp");
        $securityGroup->setVpcId(["Ref" => $vpcName]);

        //inbound for load balancer access
        $inbound->setFromPort("80");
        $inbound->setToPort("80");
        $inbound->setSourceSecurityGroupId(["Fn::GetAtt" => [$loadBalancerSG, "GroupId"]]);
        $loadBalancerAccess = $inbound->getEmbeddedSecurityGroupIngress();
        //i made this public for now because of the square1 test
        //normal it would be a domain ip either from a company vpn or personal one.
        $sshInBound = new  SecurityGroupIngress("tcp");
        $sshInBound->setToPort("22");
        $sshInBound->setFromPort("22");
        $sshInBound->setCidrIp("0.0.0.0/0");
        $sshAccess = $sshInBound->getEmbeddedSecurityGroupIngress();

        $securityGroup->setSecurityGroupIngress([$loadBalancerAccess, $sshAccess]);
        $securityGroup->setTags([
            ["Key" => "Name", "Value" => "WebBlog Private Access"]
        ]);
        return $securityGroup;
    }

    public function createDBSecurityGroup($vpcName, $ec2SecurityGroup)
    {
        $securityGroup = new SecurityGroup("Allow tcp on port 3306 from EC2");
        $inbound = new SecurityGroupIngress("tcp");
        $securityGroup->setVpcId(["Ref" => $vpcName]);

        //inbound for database access
        $inbound->setFromPort("3306");
        $inbound->setToPort("3306");
        $inbound->setSourceSecurityGroupId(["Fn::GetAtt" => [$ec2SecurityGroup, "GroupId"]]);
        $databaseAccess = $inbound->getEmbeddedSecurityGroupIngress();


        $securityGroup->setSecurityGroupIngress([$databaseAccess]);
        $securityGroup->setTags([
            ["Key" => "Name", "Value" => "WebBlog EC2-Database Access"]
        ]);
        return $securityGroup;
    }

    public function createLaunchConfiguration($imageId, $ec2SecurityGroup, $keyPair, $userData)
    {
        return new LaunchConfiguration(array(
            "Type" => AutoScalingLaunchConfiguration,
            "Properties" => [
                "ImageId" => ["Ref" => $imageId],
                "InstanceType" => "t2.micro",
                "AssociatePublicIpAddress" => true,
                "SecurityGroups" => [["Fn::GetAtt" => [$ec2SecurityGroup, "GroupId"]]],
                "KeyName" => ["Ref" => $keyPair],
                "UserData" => Base64::convertToBase($userData)
            ]
        ));
    }

    public function createTargetGroup($targetGroupName, $vpcName)
    {
        return new TargetGroup(array(
            "Type" => ElasticLoadBalancingV2TargetGroup,
            "Properties" => [
                "Name" => $targetGroupName,
                "Port" => "80",
                "Protocol" => "HTTP",
                "VpcId" => ["Ref" => $vpcName]
            ]
        ));
    }

    public function createLoadBalancerListener($loadBalancer, $targetGroupName)
    {
        return new Listener(array(
            "Type" => ElasticLoadBalancingV2Listener,
            "Properties" => [
                "LoadBalancerArn" => ["Ref" => $loadBalancer],
                "Port" => 80,
                "Protocol" => "HTTP",
                "DefaultActions" => [[
                    "Type" => "forward",
                    "ForwardConfig" => [
                        "TargetGroups" => [[
                            "TargetGroupArn" => ["Ref" => $targetGroupName]
                        ]]
                    ]
                ]],
            ]
        ));
    }

    public function createAutoScalingGroup($autoScalingGroup, $subnets, $launchConfiguration, $targetGroup)
    {
        return new AutoScalingGroup(array(
            "Type" => AutoScalingAutoScalingGroup,
            "Properties" => [
                "DesiredCapacity" => "1",
                "MinSize" => "1",
                "MaxSize" => "3",
                "VPCZoneIdentifier" => [["Ref" => $subnets[0]], ["Ref" => $subnets[1]]],
                "LaunchConfigurationName" => ["Ref" => $launchConfiguration],
                "TargetGroupARNs" => [["Ref" => $targetGroup]],
                "Tags" => [
                    ["Key" => "Name", "PropagateAtLaunch" => true, "Value" => $autoScalingGroup]
                ]
            ]
        ));
    }


    public function createLoadBalancer($name, $lBSecurityGroup, $subnets)
    {
        return new LoadBalancer(array(
            "Type" => ElasticLoadBalancingV2LoadBalancer,
            "Properties" => [
                "Name" => $name,
                "Scheme" => "internet-facing",
                "Type" => "application",
                "SecurityGroups" => [["Fn::GetAtt" => [$lBSecurityGroup, "GroupId"]]],
                "Subnets" => [["Ref" => $subnets[0]], ["Ref" => $subnets[1]]],
                "Tags" => [
                    ["Key" => "Name", "Value" => $name]
                ]
            ]
        ));
    }

    public function createDataBase($dbIdentifier, $dbName, $dbUserName, $dbPassword, $dbSecurityGroup, $subnetGroupName)
    {
        return new DbInstance(array(
            "Type" => RDSDBInstance,
            "Properties" => [
                "DBInstanceIdentifier" => $dbIdentifier,
                "DBName" => ["Ref" => $dbName],
                "DBInstanceClass" => "db.t3.micro",
                "AllocatedStorage" => "20",
                "Engine" => "MySQL",
                "EngineVersion" => "8.0.16",
                "MasterUsername" => ["Ref" => $dbUserName],
                "MasterUserPassword" => ["Ref" => $dbPassword],
                "DBSubnetGroupName" => ["Ref" => $subnetGroupName],
                "VPCSecurityGroups" => [["Fn::GetAtt" => [$dbSecurityGroup, "GroupId"]]],
                "Tags" => [
                    ["Key" => "Name", "Value" => $dbIdentifier]
                ]
            ]
        ));
    }

    public function createDBSubnetGroup($groupName, $subnets)
    {
        return new DbInstance(array(
            "Type" => "AWS::RDS::DBSubnetGroup",
            "Properties" => [
                "DBSubnetGroupDescription" => "Subnet Group for mysql",
                "DBSubnetGroupName" => $groupName,

                "SubnetIds" => [["Ref" => $subnets[0]], ["Ref" => $subnets[1]]],

                "Tags" => [
                    ["Key" => "Name", "Value" => $groupName]
                ]
            ]
        ));
    }

    public function createDbParameter($description, $default, $noEcho = true)
    {
        $parameter = new Parameter("String");
        $parameter->setConstraintDescription($description);
        $parameter->setDefault($default);
        $parameter->setAllowedPattern("[a-zA-Z][a-zA-Z0-9]*");
        $parameter->setNoEcho($noEcho);
        $parameter->setMinLength("4");

        return $parameter;
    }

    public function createUserData($github, $dbName, $username, $password, $dbHost)
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

        //clone Square1 Web blog Git repo
        $joins->addLine("cd /var/www/html ");

        $joins->addLine(["Fn::Sub" => "sudo git clone \${GitHubUrl} "]);

        $joins->addLine("cd /var/www/html/square1-test ");

        //set rights and permissions
        $joins->addLine("sudo chown -R \$USER:\$USER /var/www/html/square1-test ");
        $joins->addLine("sudo chmod -R 755 /var/www ");


        //install composer packages
        $joins->addLine("sudo composer install --ignore-platform-reqs ");
        $joins->addLine("sudo chmod -R 777 /var/www/html/square1-test/storage ");


        //install npm packages
        $joins->addLine("npm install ");
        $joins->addLine("npm run prod ");

        //create env file and generate application key
        $joins->addLine("cp .env.example .env ");
        $joins->addLine("php artisan key:gen ");

        //set db credentials

        $joins->addLine(["Fn::Sub" => "php artisan env:set DB_HOST \${WebBlogDatabaseInstance.Endpoint.Address} "]);
        $joins->addLine(["Fn::Sub" => "php artisan env:set DB_DATABASE \${DBName} "]);
        $joins->addLine(["Fn::Sub" => "php artisan env:set DB_USERNAME \${DBUserName} "]);
        $joins->addLine(["Fn::Sub" => "php artisan env:set DB_PASSWORD \${DBPassword} "]);


        //email credentials
        //hi ignore this for now

        $joins->addLine("sudo chmod 777 /etc/httpd/conf.d/welcome.conf ");
        $joins->addLine("sudo mv welcome.conf /etc/httpd/conf.d ");

        //restart apache
        $joins->addLine("sudo systemctl restart httpd.service ");

        return $joins->getJoin();


    }

    public function getScalingPolicy($autoScalingGroup)
    {
        $scaleUp = new ScalingPolicy(array(
            "Type" => "AWS::AutoScaling::ScalingPolicy",
            "Properties" => [
                "AdjustmentType" => "ChangeInCapacity",
                "AutoScalingGroupName" => ["Ref" => $autoScalingGroup],
                "Cooldown" => "1",
                "ScalingAdjustment" => "1",
            ]
        ));

        $scaleDown = new ScalingPolicy(array(
            "Type" => "AWS::AutoScaling::ScalingPolicy",
            "Properties" => [
                "AdjustmentType" => "ChangeInCapacity",
                "AutoScalingGroupName" => ["Ref" => $autoScalingGroup],
                "Cooldown" => "1",
                "ScalingAdjustment" => "-1",
            ]
        ));

        return [$scaleUp, $scaleDown];

    }

    public function cloudWatchAlarm($autoScalingGroup, $scaleUp, $scaleDown)
    {
        $alarmHigh = new Alarm(array(
            "Type" => "AWS::CloudWatch::Alarm",
            "Properties" => [
                "EvaluationPeriods" => "1",
                "Statistic" => "Average",
                "Threshold" => "70",
                "AlarmDescription" => "Trigger alarm if memory is higher than 70% for 60 Seconds",
                "Period" => "60",
                "AlarmActions" => ["Ref" => $scaleUp],
                "Namespace" => "WebBlogCWA",
                "Dimensions" => [
                    "Name" => "AutoScalingGroupName",
                    "Value" => ["Ref" => $autoScalingGroup],
                ],
                "ComparisonOperator" => "GreaterThanThreshold",
                "MetricName" => "WebBlogMemUsedPercent"
            ]
        ));

        $alarmLow = new Alarm(array(
            "Type" => "AWS::CloudWatch::Alarm",
            "Properties" => [
                "EvaluationPeriods" => "1",
                "Statistic" => "Average",
                "Threshold" => "30",
                "AlarmDescription" => "Trigger alarm if memory is lower than 30% for 60 Seconds",
                "Period" => "60",
                "AlarmActions" => ["Ref" => $scaleDown],
                "Namespace" => "WebBlogCWA",
                "Dimensions" => [
                    "Name" => "AutoScalingGroupName",
                    "Value" => ["Ref" => $autoScalingGroup],
                ],
                "ComparisonOperator" => "LessThanOrEqualToThreshold",
                "MetricName" => "WebBlogMemUsedPercent"
            ]
        ));

        return [$alarmHigh, $alarmLow];

    }

    private function createOutput($loadBalancerName, $dbRef)
    {
        $publicDns = new Outputs("PublicDns");
        $publicDns->setDescription("Public dns of the load balancer");
        $publicDns->setValue(["Fn::GetAtt" => [$loadBalancerName, "DNSName"]]);

        //output for web url
        $dbEndpoint = new Outputs("DatabaseEndpoint");
        $dbEndpoint->setDescription("DB instance endpoint");
        $dbEndpoint->setValue(["Fn::GetAtt" => [$dbRef, "Endpoint.Address"]]);

        return [$publicDns, $dbEndpoint];
    }


}

$webBlog = new Square1Deployments();
$webBlog->createTemplate();