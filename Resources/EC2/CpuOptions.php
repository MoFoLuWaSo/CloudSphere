<?php


namespace Resources\EC2;


class CpuOptions
{
    private $coreCount;
    private $thredsPerCore;

    /**
     * CpuOptions constructor.
     * @param $coreCount
     * @param $thredsPerCore
     */
    public function __construct($coreCount, $thredsPerCore)
    {
        $this->coreCount = $coreCount;
        $this->thredsPerCore = $thredsPerCore;
    }

    public function getCpuOptions()
    {
        return [
            "CoreCount" => $this->coreCount,
            "ThreadsPerCore" => $this->thredsPerCore,
        ];
    }
}