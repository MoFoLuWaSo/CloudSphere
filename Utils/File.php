<?php


namespace Utils;


class File
{
    private $content;
    private $source;
    private $encoding;
    private $group;
    private $owner;
    private $mode;
    private $authentication;
    private $context;
    private $filePath;

    /**
     * File constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }


    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source): void
    {
        $this->source = $source;
    }

    /**
     * @param mixed $encoding
     */
    public function setEncoding($encoding): void
    {
        $this->encoding = $encoding;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @param mixed $authentication
     */
    public function setAuthentication($authentication): void
    {
        $this->authentication = $authentication;
    }

    /**
     * @param mixed $context
     */
    public function setContext($context): void
    {
        $this->context = $context;
    }


    public function getFile()
    {
        $files = [];

        return [$this->filePath => $files];
    }
}