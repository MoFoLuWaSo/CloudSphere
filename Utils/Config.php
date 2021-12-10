<?php


namespace Utils;


class Config extends ConditionalAdd
{
    private $packages;
    private $groups;
    private $users;
    private $sources;
    private $files;
    private $commands;
    private $services;

    /**
     * @param mixed $packages
     */
    public function setPackages(Package $packages): void
    {
        $this->packages = $packages->getPackages();
    }

    /**
     * @param mixed $groups
     */
    public function setGroups(Group $groups): void
    {
        $this->groups = $groups->getGroups();
    }

    /**
     * @param mixed $users
     */
    public function setUsers(User $users): void
    {
        $this->users = $users->getUser();
    }

    /**
     * @param $destinationPath
     * @param $sourceUrl
     */
    public function setSource($destinationPath, $sourceUrl): void
    {
        $this->sources[$destinationPath] = $sourceUrl;
    }

    /**
     * @param mixed $files
     */
    public function setFiles(File $files): void
    {
        $this->files = $files->getFile();
    }

    /**
     * @param mixed $commands
     */
    public function setCommands(Commands $commands): void
    {
        $this->commands = $commands->getCommands();
    }

    /**
     * @param mixed $services
     * @param string $serviceType
     */
    public function setServices(Service $services, $serviceType = "sysvinit"): void
    {
        $this->services[$serviceType] = $services->getServices();
    }


    public function getConfigs()
    {

        $configs = [];
        $configs = $this->conditionalAdd($configs, "packages", $this->packages);
        $configs = $this->conditionalAdd($configs, "groups", $this->groups);
        $configs = $this->conditionalAdd($configs, "users", $this->users);
        $configs = $this->conditionalAdd($configs, "sources", $this->sources);
        $configs = $this->conditionalAdd($configs, "files", $this->files);
        $configs = $this->conditionalAdd($configs, "commands", $this->commands);
        $configs = $this->conditionalAdd($configs, "services", $this->services);

        return $configs;
    }


}