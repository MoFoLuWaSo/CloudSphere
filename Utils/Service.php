<?php


namespace Utils;


class Service extends ConditionalAdd
{

    private $ensureRunning;
    private $enabled;
    private $files;
    private $sources;
    private $packages;
    private $commands;
    private $serviceName;

    /**
     * Service constructor.
     * @param $serviceName
     */
    public function __construct($serviceName)
    {
        $this->serviceName = $serviceName;
    }


    /**
     * @param mixed $ensureRunning
     */
    public function setEnsureRunning($ensureRunning): void
    {
        $this->ensureRunning = $ensureRunning;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files): void
    {
        $this->files = $files;
    }

    /**
     * @param mixed $sources
     */
    public function setSources($sources): void
    {
        $this->sources = $sources;
    }

    /**
     * @param mixed $packages
     */
    public function setPackages($packages): void
    {
        $this->packages = $packages;
    }

    /**
     * @param mixed $commands
     */
    public function setCommands($commands): void
    {
        $this->commands = $commands;
    }

    public function getServices()
    {
        $services = [];
        $services = $this->conditionalAdd($services, "ensureRunning", $this->ensureRunning);
        $services = $this->conditionalAdd($services, "enabled", $this->enabled);
        $services = $this->conditionalAdd($services, "files", $this->files);
        $services = $this->conditionalAdd($services, "sources", $this->sources);
        $services = $this->conditionalAdd($services, "packages", $this->packages);
        $services = $this->conditionalAdd($services, "commands", $this->commands);

        return [$this->serviceName => $services];
    }
}