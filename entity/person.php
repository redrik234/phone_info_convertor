<?php

namespace Entity;

use InvalidArgumentException;
use stdClass;

class Person {

    private string $name = '';
    private string $position = '';
    private ?string $email = '';
    private ?string $phone = '';
    private ?string $location = '';
    private ?stdClass $additional_info = null;

    public function __construct(?stdClass $info) {
        // if (self::is_empty($info->Name)) {
        //     throw new InvalidArgumentException('Property "Name" is empty');
        // }

        // if (self::is_empty($info->Phone)) {
        //     throw new InvalidArgumentException('Property "Phone" is empty');
        // }

        $this->name = $info->Name;
        $this->position = $info->JobTitle;
        $this->email = $info->Email;
        $this->phone = $info->Phone;
        $this->location = $info->Location;
        $this->additional_info = $info->AdditionalInfo;
    }

    private static function is_empty($val) {
        if (empty($val)) {
            return true;
        }
        return false;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_position(){
        return $this->position;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_phone() {
        return $this->phone;
    }

    public function get_location() {
        return $this->location;
    }

    public function get_additional_info() {
        return $this->additional_info;
    }
}