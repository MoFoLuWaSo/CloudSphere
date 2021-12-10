<?php


namespace Utils;


class Commands extends ConditionalAdd
{
    private $command;
    private $env;
    private $cwd;
    private $test;
    private $ignoreErrors;
    private $waitAfterCompletion;
    private $commandName;

    /**
     * Commands constructor.
     * @param $commandName
     */
    public function __construct($commandName)
    {
        $this->commandName = $commandName;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command): void
    {
        $this->command = $command;
    }

    /**
     * @param mixed $env
     */
    public function setEnv($env): void
    {
        $this->env = $env;
    }

    /**
     * @param mixed $cwd
     */
    public function setCwd($cwd): void
    {
        $this->cwd = $cwd;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test): void
    {
        $this->test = $test;
    }

    /**
     * @param mixed $ignoreErrors
     */
    public function setIgnoreErrors($ignoreErrors): void
    {
        $this->ignoreErrors = $ignoreErrors;
    }

    /**
     * @param mixed $waitAfterCompletion
     */
    public function setWaitAfterCompletion($waitAfterCompletion): void
    {
        $this->waitAfterCompletion = $waitAfterCompletion;
    }


    public function getCommands()
    {
        $commands = [];
        $commands = $this->conditionalAdd($commands, "command", $this->command);
        $commands = $this->conditionalAdd($commands, "env", $this->env);
        $commands = $this->conditionalAdd($commands, "cwd", $this->cwd);
        $commands = $this->conditionalAdd($commands, "test", $this->test);
        $commands = $this->conditionalAdd($commands, "ignoreErrors", $this->ignoreErrors);
        $commands = $this->conditionalAdd($commands, "waitAfterCompletion", $this->waitAfterCompletion);

        return [$this->commandName => $commands];

    }


}