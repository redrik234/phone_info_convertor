<?php
namespace Entity;

require_once(__DIR__ . '/person.php');

use stdClass;
use Entity\Person;

class Department {

    private string $name = '';
    private ?string $code = '';
    private ?string $head_department = '';
    private ?string $phone = '';
    private ?string $email = '';
    private ?string $location = '';
    private ?array $employees = [];

    private ?array $childs = [];
    private ?Person $manager = null;

    public function __construct(stdClass $info) {
        $this->name = $info->DepartmentName;
        $this->code = $info->DepartmentCode;
        $this->head_department = $info->HeadDepartment;
        $this->email = $info->Email;
        $this->phone = $info->Phone;
        $this->location = $info->Location;
        $this->manager = $info->Manager ? new Person($info->Manager) : null;
        foreach($info->Employees as $person_info) {
            $this->employees[] = new Person($person_info);
        }
        if (isset($info->Childs)) {
            $this->childs = self::create_childs($info->Childs);
        }
    }

    private static function create_childs($childs) {
        $result = [];
        foreach ($childs as $child) {
            $result[] = new Department($child);
        }
        return $result;
    }

    public function get_html($template_engine) {
        $html = [];

        if ($this->childs) {
            $data = $this->get_template_data();
            $data['childs'] = self::get_childs_html($this->childs, $template_engine);
            $data['uniqId'] = uniqid('group');
            $html = $template_engine->render('item_with_child', $data);
        }
        else {
            if ($this->is_empty()) {
                return null;
            }
            $html = $template_engine->render('item', $this->get_template_data());
        }

        return $html;
    }

    private static function get_childs_html($childs, $t_e) {
        $result = [];
        foreach ($childs as $department) {
            $curr_childs = $department->get_childs();
            if ($curr_childs) {
                $template_childs = self::get_childs_html($curr_childs, $t_e);
            }
            else {
                $data = $department->get_template_data();
                if (!$department->is_empty()) {
                    $result[] =  $t_e->render('item', $data);
                }
                continue;
            }
            if (!$department->is_empty()) {
                $data = $department->get_template_data();
                $data['uniqId'] = uniqid('group');
                $data['childs'] = $template_childs;
                $html = $t_e->render('child', $data);
                $result[] = $html;
            }
        }
        return implode(PHP_EOL, $result);
    }

    public function get_template_data() {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'headDepartment' => $this->head_department,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'manager' => $this->manager ? $this->manager->get_template_data() : null,
            'employees' => array_map(function($emp) {
                return $emp->get_template_data();
            },$this->employees)
        ];
    }

    public function is_empty() {
        if (!$this->phone && !$this->email 
        && !$this->location && !$this->manager
        && empty($this->employees
        && empty($this->childs))) {
            return true;
        }
        return false;
    }

    public function set_child($department) {
        $this->childs[$department->get_name()] = $department;
    }

    public function get_childs() {
        return $this->childs;
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