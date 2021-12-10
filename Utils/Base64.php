<?php


namespace Utils;


class Base64
{

    public static function convertToBase($data)
    {
        return ["Fn::Base64" => $data];
    }
}