<?php


namespace Utils;


class User extends ConditionalAdd
{
    private $uid;
    private $groups;
    private $homeDir;
    private $userName;

    /**
     * User constructor.
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @param mixed $homeDir
     */
    public function setHomeDir($homeDir): void
    {
        $this->homeDir = $homeDir;
    }


    public function getUser()
    {
        $users = [];
        $users = $this->conditionalAdd($users, "uid", $this->uid);
        $users = $this->conditionalAdd($users, "groups", $this->groups);
        $users = $this->conditionalAdd($users, "homeDir", $this->homeDir);

        return [$this->userName => $users];
    }

}