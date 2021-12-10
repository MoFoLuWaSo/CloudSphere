<?php


namespace Utils;


class ConditionalAdd
{
    public function conditionalAdd($data, $key, $value)
    {
        if (!empty($value)) {
            $data[$key] = $value;
        }

        return $data;
    }
}