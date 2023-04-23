<?php
require_once(__DIR__ . '/entity/department.php');
require_once(__DIR__ . '/mustache/mustache.php');
require_once(__DIR__ . '/lib/lib.php');

use Entity\Department;

$m = new Mustache_Engine([
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/template')
]);

const PATH = __DIR__ . '/phonebook2.json';
$json_content = file_get_contents(PATH);

$json = json_decode($json_content);

$department_collection = [];

$tree = [];

foreach ($json as $department) {
    $department_collection[$department->DepartmentName] = $department;
    if ($department->HeadDepartment === null) {
        $tree[$department->DepartmentName] = $department;
    }
}

$dict = [];
$html = null;
foreach($tree as &$department) {
    $department->Childs = search_childs($department, $department_collection);
    $dep = new Department($department);
    $html[] = $dep->get_html($m);
}

// file_put_contents('./tree.json', print_r($tree, true));
// file_put_contents('./dict.json', print_r($dict, true));

$template_data = [];

print_r($template_data);
$output = $m->render('page', ['data' => $html]);

//echo $output;
file_put_contents(__DIR__ . '/index.html', $output);