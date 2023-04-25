<?php

namespace Entity;

use stdClass;

class Person {

    private string $name = '';
    private string $position = '';
    private ?string $email = '';
    private ?string $phone = '';
    private ?string $location = '';
    private ?string $additional_info = '';

    public function __construct(?stdClass $info) {
        $this->name = $info->Name;
        $this->position = $info->JobTitle;
        $this->email = $info->Email;
        $this->phone = $info->Phone;
        $this->location = $info->Location;
        $this->additional_info = $info->AdditionalInfo;
    }

    public function get_template_data() {
        return [
            'name' => $this->name,
            'position' => $this->position,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'add_info' => $this->additional_info
        ];
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