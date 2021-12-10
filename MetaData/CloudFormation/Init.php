<?php


namespace MetaData\CloudFormation;


use Utils\Config;

class Init
{
    private $configSets;
    private $configuration;

    /**
     * @param mixed $configSets
     */
    public function setConfigSets($name, $configSets): void
    {
        $this->configSets[$name] = $configSets;
    }

    /**
     * @param $configSetName
     * @param mixed $configuration
     */
    public function setConfiguration($configSetName, Config $configuration): void
    {
        $this->configuration[$configSetName] = $configuration->getConfigs();
    }


    public function getConfigurations()
    {
        $configSets["configSets"] = $this->configSets;
        $configSets = array_merge($configSets, $this->configuration);
        return $configSets;

    }

}