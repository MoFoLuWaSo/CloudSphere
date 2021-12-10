<?php


namespace Utils;


class Joins
{
    private $join;
    private $delimiter = "";

    /**
     * Joins constructor.
     * @param string $delimiter
     */
    public function __construct(string $delimiter = "")
    {
        $this->delimiter = $delimiter;
    }


    public function setJoin(array $lines)
    {
        $this->join = $lines;
    }

    public function addLine($line)
    {
        $this->join[] = $line;
    }

    /**
     * @return mixed
     */
    public function getJoin()
    {
        return ["Fn::Join" => [$this->delimiter, $this->join]];
    }


}