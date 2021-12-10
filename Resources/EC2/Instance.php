<?php


namespace Resources\EC2;

use Formation\Metadata;
use Formation\Resource;
use Utils\ConditionalAdd;

class Instance extends ConditionalAdd implements Resource
{


    private $additionalInfo;
    private $affinity;
    private $availabilityZone;
    private $blockDeviceMappings;
    private $cpuOptions;
    private $creditSpecification;
    private $disableApiTermination = false;
    private $ebsOptimized = false;
    private $elasticGpuSpecifications;
    private $elasticInferenceAccelerators;
    private $enclaveOptions;
    private $hibernationOptions;
    private $hostId;
    private $hostResourceGroupArn;
    private $iamInstanceProfile;
    private $imageId;
    private $instanceInitiatedShutdownBehavior;
    private $instanceType;
    private $ipv6AddressCount;
    private $ipv6Addresses;
    private $kernelId;
    private $keyName;
    private $launchTemplate;
    private $licenseSpecifications;
    private $metadata;
    private $monitoring;
    private $networkInterfaces;
    private $placementGroupName;
    private $privateIpAddress;
    private $ramdiskId;
    private $securityGroupIds;
    private $securityGroups = [];
    private $sourceDestCheck;
    private $ssmAssociations;
    private $subnetId;
    private $tags;
    private $tenancy;
    private $userData;
    private $volumes;

    /**
     * @param mixed $additionalInfo
     * This property is reserved for internal use. If you use it, the stack fails with this error: Bad property set: [Testing this property] (Service: AmazonEC2; Status Code: 400; Error Code: InvalidParameterCombination; Request ID: 0XXXXXX-49c7-4b40-8bcc-76885dcXXXXX).
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Some interruptions
     */
    public function setAdditionalInfo($additionalInfo): void
    {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * @param mixed $affinity
     * Indicates whether the instance is associated with a dedicated host. If you want the instance to always restart on the same host on which it was launched, specify host. If you want the instance to restart on any available host, but try to launch onto the last host it ran on (on a best-effort basis), specify default.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Some interruptions
     */
    public function setAffinity($affinity): void
    {
        $this->affinity = $affinity;
    }

    /**
     * @param mixed $availabilityZone
     * The Availability Zone of the instance.
     *
     * If not specified, an Availability Zone will be automatically chosen for you based on the load balancing criteria for the Region.
     *
     * This parameter is not supported by DescribeImageAttribute.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setAvailabilityZone($availabilityZone): void
    {
        $this->availabilityZone = $availabilityZone;
    }

    /**
     * @param mixed $blockDeviceMappings
     * The block device mapping entries that defines the block devices to attach to the instance at launch.
     *
     * By default, the block devices specified in the block device mapping for the AMI are used. You can override the AMI block device mapping using the instance block device mapping. For the root volume, you can override only the volume size, volume type, volume encryption settings, and the DeleteOnTermination setting.
     *
     * Important
     * After the instance is running, you can modify only the DeleteOnTermination parameter for the attached volumes without interrupting the instance. Modifying any other parameter results in instance replacement.
     *
     * Required: No
     *
     * Type: List of BlockDeviceMapping
     *
     * Update requires: Some interruptions
     */
    public function setBlockDeviceMappings($blockDeviceMappings): void
    {
        $this->blockDeviceMappings = $blockDeviceMappings;
    }

    /**
     * @param mixed $cpuOptions
     * The CPU options for the instance. For more information, see Optimize CPU options in the Amazon Elastic Compute Cloud User Guide.
     *
     * Required: No
     *
     * Type: CpuOptions
     *
     * Update requires: Replacement
     */
    public function setCpuOptions($cpuOptions): void
    {
        $this->cpuOptions = $cpuOptions;
    }

    /**
     * @param mixed $creditSpecification
     * The credit option for CPU usage of the burstable performance instance. Valid values are standard and unlimited. To change this attribute after launch, use ModifyInstanceCreditSpecification. For more information, see Burstable performance instances in the Amazon EC2 User Guide.
     *
     * Default: standard (T2 instances) or unlimited (T3/T3a instances)
     *
     * For T3 instances with host tenancy, only standard is supported.
     *
     * Required: No
     *
     * Type: CreditSpecification
     *
     * Update requires: No interruption
     */
    public function setCreditSpecification($creditSpecification): void
    {
        $this->creditSpecification = $creditSpecification;
    }

    /**
     * @param bool $disableApiTermination
     * If you set this parameter to true, you can't terminate the instance using the Amazon EC2 console, CLI, or API; otherwise, you can. To change this attribute after launch, use ModifyInstanceAttribute. Alternatively, if you set InstanceInitiatedShutdownBehavior to terminate, you can terminate the instance by running the shutdown command from the instance.
     *
     * Default: false
     *
     * Required: No
     *
     * Type: Boolean
     *
     * Update requires: No interruption
     */
    public function setDisableApiTermination(bool $disableApiTermination): void
    {
        $this->disableApiTermination = $disableApiTermination;
    }

    /**
     * @param bool $ebsOptimized
     * Indicates whether the instance is optimized for Amazon EBS I/O. This optimization provides dedicated throughput to Amazon EBS and an optimized configuration stack to provide optimal Amazon EBS I/O performance. This optimization isn't available with all instance types. Additional usage charges apply when using an EBS-optimized instance.
     *
     * Default: false
     *
     * Required: No
     *
     * Type: Boolean
     *
     * Update requires: Some interruptions
     */
    public function setEbsOptimized(bool $ebsOptimized): void
    {
        $this->ebsOptimized = $ebsOptimized;
    }

    /**
     * @param mixed $elasticGpuSpecifications
     * An elastic GPU to associate with the instance. An Elastic GPU is a GPU resource that you can attach to your Windows instance to accelerate the graphics performance of your applications. For more information, see Amazon EC2 Elastic GPUs in the Amazon EC2 User Guide.
     *
     * Required: No
     *
     * Type: List of ElasticGpuSpecification
     *
     * Update requires: Replacement
     */
    public function setElasticGpuSpecifications($elasticGpuSpecifications): void
    {
        $this->elasticGpuSpecifications = $elasticGpuSpecifications;
    }

    /**
     * @param mixed $elasticInferenceAccelerators
     * An elastic inference accelerator to associate with the instance. Elastic inference accelerators are a resource you can attach to your Amazon EC2 instances to accelerate your Deep Learning (DL) inference workloads.
     *
     * You cannot specify accelerators from different generations in the same request.
     *
     * Required: No
     *
     * Type: List of ElasticInferenceAccelerator
     *
     * Update requires: Replacement
     */
    public function setElasticInferenceAccelerators($elasticInferenceAccelerators): void
    {
        $this->elasticInferenceAccelerators = $elasticInferenceAccelerators;
    }

    /**
     * @param mixed $enclaveOptions
     * Indicates whether the instance is enabled for AWS Nitro Enclaves.
     *
     * Required: No
     *
     * Type: EnclaveOptions
     *
     * Update requires: Replacement
     */
    public function setEnclaveOptions($enclaveOptions): void
    {
        $this->enclaveOptions = $enclaveOptions;
    }

    /**
     * @param mixed $hibernationOptions
     * Indicates whether an instance is enabled for hibernation. For more information, see Hibernate your instance in the Amazon EC2 User Guide.
     *
     * You can't enable hibernation and AWS Nitro Enclaves on the same instance.
     *
     * Required: No
     *
     * Type: HibernationOptions
     *
     * Update requires: Replacement
     */
    public function setHibernationOptions($hibernationOptions): void
    {
        $this->hibernationOptions = $hibernationOptions;
    }

    /**
     * @param mixed $hostId
     * If you specify host for the Affinity property, the ID of a dedicated host that the instance is associated with. If you don't specify an ID, Amazon EC2 launches the instance onto any available, compatible dedicated host in your account. This type of launch is called an untargeted launch. Note that for untargeted launches, you must have a compatible, dedicated host available to successfully launch instances.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Some interruptions
     */
    public function setHostId($hostId): void
    {
        $this->hostId = $hostId;
    }

    /**
     * @param mixed $hostResourceGroupArn
     * The ARN of the host resource group in which to launch the instances. If you specify a host resource group ARN, omit the Tenancy parameter or set it to host.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setHostResourceGroupArn($hostResourceGroupArn): void
    {
        $this->hostResourceGroupArn = $hostResourceGroupArn;
    }

    /**
     * @param mixed $iamInstanceProfile
     * The name of an IAM instance profile. To create a new IAM instance profile, use the AWS::IAM::InstanceProfile resource.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: No interruption
     */
    public function setIamInstanceProfile($iamInstanceProfile): void
    {
        $this->iamInstanceProfile = $iamInstanceProfile;
    }

    /**
     * @param mixed $imageId
     * The ID of the AMI. An AMI ID is required to launch an instance and must be specified here or in a launch template.
     *
     * Required: Conditional
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setImageId($imageId): void
    {
        $this->imageId = $imageId;
    }

    /**
     * @param mixed $instanceInitiatedShutdownBehavior
     * Indicates whether an instance stops or terminates when you initiate shutdown from the instance (using the operating system command for system shutdown).
     *
     * Default: stop
     *
     * Required: No
     *
     * Type: String
     *
     * Allowed values: stop | terminate
     *
     * Update requires: No interruption
     */
    public function setInstanceInitiatedShutdownBehavior($instanceInitiatedShutdownBehavior): void
    {
        $this->instanceInitiatedShutdownBehavior = $instanceInitiatedShutdownBehavior;
    }

    /**
     * @param mixed $instanceType
     * The instance type. For more information, see Instance types in the Amazon EC2 User Guide.
     *
     * Default: m1.small
     *
     * Required: No
     *
     * Type: String
     * Allowed values: a1.2xlarge | a1.4xlarge | a1.large | a1.medium | a1.metal | a1.xlarge | c1.medium | c1.xlarge | c3.2xlarge |...
     * Update requires: Some interruptions
     */
    public function setInstanceType($instanceType): void
    {
        $this->instanceType = $instanceType;
    }

    /**
     * @param mixed $ipv6AddressCount
     * [EC2-VPC] The number of IPv6 addresses to associate with the primary network interface. Amazon EC2 chooses the IPv6 addresses from the range of your subnet. You cannot specify this option and the option to assign specific IPv6 addresses in the same request. You can specify this option if you've specified a minimum number of instances to launch.
     *
     * You cannot specify this option and the network interfaces option in the same request.
     *
     * Required: No
     *
     * Type: Integer
     *
     * Update requires: Replacement
     */
    public function setIpv6AddressCount($ipv6AddressCount): void
    {
        $this->ipv6AddressCount = $ipv6AddressCount;
    }

    /**
     * @param mixed $ipv6Addresses
     * [EC2-VPC] The IPv6 addresses from the range of the subnet to associate with the primary network interface. You cannot specify this option and the option to assign a number of IPv6 addresses in the same request. You cannot specify this option if you've specified a minimum number of instances to launch.
     *
     * You cannot specify this option and the network interfaces option in the same request.
     *
     * Required: No
     *
     * Type: List of InstanceIpv6Address
     *
     * Update requires: Replacement
     */
    public function setIpv6Addresses($ipv6Addresses): void
    {
        $this->ipv6Addresses = $ipv6Addresses;
    }

    /**
     * @param mixed $kernelId
     * The ID of the kernel.
     *
     * Important
     * We recommend that you use PV-GRUB instead of kernels and RAM disks. For more information, see PV-GRUB in the Amazon EC2 User Guide.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Some interruptions
     */
    public function setKernelId($kernelId): void
    {
        $this->kernelId = $kernelId;
    }

    /**
     * @param mixed $keyName
     * The name of the key pair. You can create a key pair using CreateKeyPair or ImportKeyPair.
     *
     * Important
     * If you do not specify a key pair, you can't connect to the instance unless you choose an AMI that is configured to allow users another way to log in.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setKeyName($keyName): void
    {
        $this->keyName = $keyName;
    }

    /**
     * @param mixed $launchTemplate
     * The launch template to use to launch the instances. Any parameters that you specify in the AWS CloudFormation template override the same parameters in the launch template. You can specify either the name or ID of a launch template, but not both.
     *
     * Required: No
     *
     * Type: LaunchTemplateSpecification
     *
     * Update requires: Replacement
     */
    public function setLaunchTemplate($launchTemplate): void
    {
        $this->launchTemplate = $launchTemplate;
    }

    /**
     * @param mixed $licenseSpecifications
     * The license configurations.
     *
     * Required: No
     *
     * Type: List of LicenseSpecification
     *
     * Update requires: Replacement
     */
    public function setLicenseSpecifications($licenseSpecifications): void
    {
        $this->licenseSpecifications = $licenseSpecifications;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata(Metadata $metadata): void
    {
        $this->metadata = $metadata->getData();
    }

    /**
     * @param mixed $monitoring
     * Specifies whether detailed monitoring is enabled for the instance.
     *
     * Required: No
     *
     * Type: Boolean
     *
     * Update requires: No interruption
     */
    public function setMonitoring($monitoring): void
    {
        $this->monitoring = $monitoring;
    }

    /**
     * @param mixed $networkInterfaces
     * The network interfaces to associate with the instance.
     *
     * Note
     * If you use this property to point to a network interface, you must terminate the original interface before attaching a new one to allow the update of the instance to succeed.
     *
     * If this resource has a public IP address and is also in a VPC that is defined in the same template, you must use the DependsOn Attribute to declare a dependency on the VPC-gateway attachment.
     *
     * Required: No
     *
     * Type: List of NetworkInterface
     *
     * Update requires: Replacement
     */
    public function setNetworkInterfaces($networkInterfaces): void
    {
        $this->networkInterfaces = $networkInterfaces;
    }

    /**
     * @param mixed $placementGroupName
     * The name of an existing placement group that you want to launch the instance into (cluster | partition | spread).
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setPlacementGroupName($placementGroupName): void
    {
        $this->placementGroupName = $placementGroupName;
    }

    /**
     * @param mixed $privateIpAddress
     * [EC2-VPC] The primary IPv4 address. You must specify a value from the IPv4 address range of the subnet.
     *
     * Only one private IP address can be designated as primary. You can't specify this option if you've specified the option to designate a private IP address as the primary IP address in a network interface specification. You cannot specify this option if you're launching more than one instance in the request.
     *
     * You cannot specify this option and the network interfaces option in the same request.
     *
     * If you make an update to an instance that requires replacement, you must assign a new private IP address. During a replacement, AWS CloudFormation creates a new instance but doesn't delete the old instance until the stack has successfully updated. If the stack update fails, AWS CloudFormation uses the old instance to roll back the stack to the previous working state. The old and new instances cannot have the same private IP address.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setPrivateIpAddress($privateIpAddress): void
    {
        $this->privateIpAddress = $privateIpAddress;
    }

    /**
     * @param mixed $ramdiskId
     * The ID of the RAM disk to select. Some kernels require additional drivers at launch. Check the kernel requirements for information about whether you need to specify a RAM disk. To find kernel requirements, go to the AWS Resource Center and search for the kernel ID.
     *
     * Important
     * We recommend that you use PV-GRUB instead of kernels and RAM disks. For more information, see PV-GRUB in the Amazon EC2 User Guide.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Some interruptions
     */
    public function setRamdiskId($ramdiskId): void
    {
        $this->ramdiskId = $ramdiskId;
    }

    /**
     * @param mixed $securityGroupIds
     * The IDs of the security groups. You can create a security group using CreateSecurityGroup.
     *
     * If you specify a network interface, you must specify any security groups as part of the network interface.
     *
     * Required: Conditional
     *
     * Type: List of String
     *
     * Update requires: Some interruptions
     */
    public function setSecurityGroupIds($securityGroupIds): void
    {
        $this->securityGroupIds = $securityGroupIds;
    }

    /**
     * @param mixed $securityGroups
     * [EC2-Classic, default VPC] The names of the security groups. For a nondefault VPC, you must use security group IDs instead.
     *
     * You cannot specify this option and the network interfaces option in the same request. The list can contain both the name of existing Amazon EC2 security groups or references to AWS::EC2::SecurityGroup resources created in the template.
     *
     * Default: Amazon EC2 uses the default security group.
     *
     * Required: No
     *
     * Type: List of String
     *
     * Update requires: Replacement
     */
    public function setSecurityGroups($securityGroups): void
    {
        $this->securityGroups[] = $securityGroups;
    }

    /**
     * @param mixed $sourceDestCheck
     * Enable or disable source/destination checks, which ensure that the instance is either the source or the destination of any traffic that it receives. If the value is true, source/destination checks are enabled; otherwise, they are disabled. The default value is true. You must disable source/destination checks if the instance runs services such as network address translation, routing, or firewalls.
     *
     * Required: No
     *
     * Type: Boolean
     *
     * Update requires: No interruption
     */
    public function setSourceDestCheck($sourceDestCheck): void
    {
        $this->sourceDestCheck = $sourceDestCheck;
    }

    /**
     * @param mixed $ssmAssociations
     * The SSM document and parameter values in AWS Systems Manager to associate with this instance. To use this property, you must specify an IAM instance profile role for the instance. For more information, see Create an Instance Profile for Systems Manager in the AWS Systems Manager User Guide.
     *
     * Note
     * You can currently associate only one document with an instance.
     *
     * Required: No
     *
     * Type: List of SsmAssociation
     *
     * Update requires: No interruption
     */
    public function setSsmAssociations($ssmAssociations): void
    {
        $this->ssmAssociations = $ssmAssociations;
    }

    /**
     * @param mixed $subnetId
     * [EC2-VPC] The ID of the subnet to launch the instance into.
     *
     * If you specify a network interface, you must specify any subnets as part of the network interface.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Replacement
     */
    public function setSubnetId($subnetId): void
    {
        $this->subnetId = $subnetId;
    }

    /**
     * @param mixed $tags
     * The tags to add to the instance. These tags are not applied to the EBS volumes, such as the root volume.
     *
     * Required: No
     *
     * Type: List of Tag
     *
     * Update requires: No interruption
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @param mixed $tenancy
     * The tenancy of the instance (if the instance is running in a VPC). An instance with a tenancy of dedicated runs on single-tenant hardware.
     *
     * Required: No
     *
     * Type: String
     *
     * Allowed values: dedicated | default | host
     *
     * Update requires: Some interruptions
     */
    public function setTenancy($tenancy): void
    {
        $this->tenancy = $tenancy;
    }

    /**
     * @param mixed $userData
     * The user data to make available to the instance. For more information, see Running commands on your Linux instance at launch (Linux) and Adding User Data (Windows). If you are using a command line tool, base64-encoding is performed for you, and you can load the text from a file. Otherwise, you must provide base64-encoded text. User data is limited to 16 KB.
     *
     * Required: No
     *
     * Type: String
     *
     * Update requires: Some interruptions
     */
    public function setUserData($userData): void
    {
        $this->userData = $userData;
    }

    /**
     * @param mixed $volumes
     * The volumes to attach to the instance.
     *
     * Required: No
     *
     * Type: List of Volume
     *
     * Update requires: No interruption
     */
    public function setVolumes($volumes): void
    {
        $this->volumes = $volumes;
    }

    public function getInstance()
    {
        $properties = [];
        $properties = $this->conditionalAdd($properties, "AdditionalInfo", $this->additionalInfo);
        $properties = $this->conditionalAdd($properties, "Affinity", $this->affinity);
        $properties = $this->conditionalAdd($properties, "AvailabilityZone", $this->availabilityZone);
        $properties = $this->conditionalAdd($properties, "BlockDeviceMappings", $this->blockDeviceMappings);
        $properties = $this->conditionalAdd($properties, "CpuOptions", $this->cpuOptions);
        $properties = $this->conditionalAdd($properties, "CreditSpecification", $this->creditSpecification);
        $properties = $this->conditionalAdd($properties, "DisableApiTermination", $this->disableApiTermination);
        $properties = $this->conditionalAdd($properties, "EbsOptimized", $this->ebsOptimized);
        $properties = $this->conditionalAdd($properties, "ElasticGpuSpecifications", $this->elasticGpuSpecifications);
        $properties = $this->conditionalAdd($properties, "ElasticInferenceAccelerators", $this->elasticInferenceAccelerators);
        $properties = $this->conditionalAdd($properties, "EnclaveOptions", $this->enclaveOptions);
        $properties = $this->conditionalAdd($properties, "HibernationOptions", $this->hibernationOptions);
        $properties = $this->conditionalAdd($properties, "HostId", $this->hostId);
        $properties = $this->conditionalAdd($properties, "HostResourceGroupArn", $this->hostResourceGroupArn);
        $properties = $this->conditionalAdd($properties, "IamInstanceProfile", $this->iamInstanceProfile);
        $properties = $this->conditionalAdd($properties, "ImageId", $this->imageId);
        $properties = $this->conditionalAdd($properties, "InstanceInitiatedShutdownBehavior", $this->instanceInitiatedShutdownBehavior);
        $properties = $this->conditionalAdd($properties, "InstanceType", $this->instanceType);
        $properties = $this->conditionalAdd($properties, "Ipv6AddressCount", $this->ipv6AddressCount);
        $properties = $this->conditionalAdd($properties, "Ipv6Addresses", $this->ipv6Addresses);
        $properties = $this->conditionalAdd($properties, "KernelId", $this->kernelId);
        $properties = $this->conditionalAdd($properties, "KeyName", $this->keyName);
        $properties = $this->conditionalAdd($properties, "LaunchTemplate", $this->launchTemplate);
        $properties = $this->conditionalAdd($properties, "LicenseSpecifications", $this->licenseSpecifications);
        $properties = $this->conditionalAdd($properties, "Monitoring", $this->monitoring);
        $properties = $this->conditionalAdd($properties, "Metadata", $this->metadata);
        $properties = $this->conditionalAdd($properties, "NetworkInterfaces", $this->networkInterfaces);
        $properties = $this->conditionalAdd($properties, "PlacementGroupName", $this->placementGroupName);
        $properties = $this->conditionalAdd($properties, "PrivateIpAddress", $this->privateIpAddress);
        $properties = $this->conditionalAdd($properties, "RamdiskId", $this->ramdiskId);
        $properties = $this->conditionalAdd($properties, "SecurityGroupIds", $this->securityGroupIds);
        $properties = $this->conditionalAdd($properties, "SecurityGroups", $this->securityGroups);
        $properties = $this->conditionalAdd($properties, "SourceDestCheck", $this->sourceDestCheck);
        $properties = $this->conditionalAdd($properties, "SsmAssociations", $this->ssmAssociations);
        $properties = $this->conditionalAdd($properties, "SubnetId", $this->subnetId);
        $properties = $this->conditionalAdd($properties, "Tags", $this->tags);
        $properties = $this->conditionalAdd($properties, "Tenancy", $this->tenancy);
        $properties = $this->conditionalAdd($properties, "UserData", $this->userData);
        $properties = $this->conditionalAdd($properties, "Volumes", $this->volumes);


        return [
            "Type" => "AWS::EC2::Instance",
            "Properties" => $properties
        ];
    }

    public function defaultUserData($instanceName, $command)
    {
        return ["Fn::Base64" => ["Fn::Join" => ["", [
            "#!/bin/bash -xe\n",
            "yum install -y aws-cfn-bootstrap\n",
            "$command",
            "# Install the files and packages from the metadata\n",
            "/opt/aws/bin/cfn-init -v ",
            "         --stack ", ["Ref" => "AWS::StackName"],
            "         --resource $instanceName ",
            "         --configsets InstallAndRun ",
            "         --region ", ["Ref" => "AWS::Region"], "\n",

            "# Signal the status from cfn-init\n",
            "/opt/aws/bin/cfn-signal -e $? ",
            "         --stack ", ["Ref" => "AWS::StackName"],
            "         --resource $instanceName ",
            "         --region ", ["Ref" => "AWS::Region"], "\n"
        ]]]];
    }

    public function getDefaultCreationPolicy()
    {
        return [
            "ResourceSignal" => [
                "Timeout" => "PT5M"
            ]
        ];
    }

    public function getResource()
    {
        // TODO: Implement getResource() method.
        return $this->getInstance();
    }
}