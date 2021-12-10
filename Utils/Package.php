<?php


namespace Utils;


class Package extends ConditionalAdd
{
    private $rpm;
    private $yum;
    private $rubygems;
    private $msi;

    /**
     * Package constructor.
     */
    public function __construct()
    {

    }


    /**
     * @param mixed $rpm
     */
    public function setRpm($rpm): void
    {
        $this->rpm = $rpm;
    }

    /**
     * @param mixed $yum
     */
    public function setYum($yum): void
    {
        $this->yum = $yum;
    }

    /**
     * @param mixed $rubygems
     */
    public function setRubygems($rubygems): void
    {
        $this->rubygems = $rubygems;
    }

    /**
     * @param mixed $msi
     */
    public function setMsi($msi): void
    {
        $this->msi = $msi;
    }


    public function getPackages()
    {
        $packages = [];
        $packages = $this->conditionalAdd($packages, "rpm", $this->rpm);
        $packages = $this->conditionalAdd($packages, "yum", $this->yum);
        $packages = $this->conditionalAdd($packages, "rubygems", $this->rubygems);
        $packages = $this->conditionalAdd($packages, "msi", $this->msi);
        return $packages;
    }
}