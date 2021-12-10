<?php


namespace Utils;


class Group
{
    private $groups;

    /**
     * Group constructor.
     * @param $groupName
     * @param $gidValue
     */
    public function __construct($groupName, $gidValue)
    {
        $this->groups[$groupName] = ["gid"=>$gidValue];
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }


}