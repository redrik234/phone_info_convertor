<?php
namespace Entity;

require_once(__DIR__ . '/person.php');

use stdClass;
use Entity\Person;
use InvalidArgumentException;

class Department {

    private string $name = '';
    private ?string $code = '';
    private ?string $head_department = '';
    private string $phone = '';
    private ?string $email = '';
    private ?string $location = '';
    private ?array $employees = [];
    private ?Person $manager = null;

    public function __construct(stdClass $info) {
        if (self::is_empty($info->DepartmentName)) {
            throw new InvalidArgumentException('Property "DepartmentName" is empty');
        }
        // if (self::is_empty($info->Phone)) {
        //     throw new InvalidArgumentException('Property "Phone" is empty');
        // }

        $this->name = $info->DepartmentName;
        $this->code = $info->DepartmentCode;
        $this->head_department = $info->HeadDepartment;
        $this->email = $info->Email;
        $this->location = $info->Location;
        $this->manager = $info->Manager ? new Person($info->Manager) : null;
        foreach($info->Employees as $person_info) {
            $this->employees[] = new Person($person_info);
        }
    }

    private static function is_empty($val) {
        if (empty($val)) {
            return true;
        }
        return false;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_code() {
        return $this->code;
    }

    public function get_head_department() {
        return $this->head_department;
    }

    public function get_phone() {
        return $this->phone;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_location() {
        return $this->location;
    }
}