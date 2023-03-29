<?php
require_once(__DIR__ . '/entity/department.php');

use Entity\Department;

const PATH = __DIR__ . '/phonebook.json';
$json_content = file_get_contents(PATH);

$json = json_decode($json_content);

$department_collection = [];

foreach($json as $department) {
    $department_collection[] = new Department($department);
}
print_r($department_collection);