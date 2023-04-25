<?php
require_once(__DIR__ . '/entity/department.php');
require_once(__DIR__ . '/mustache/mustache.php');
require_once(__DIR__ . '/lib/lib.php');


$options = getopt('i:o:c::');

if (!$options || !isset($options['i']) || !isset($options['o'])) {
    echo 'No arguments! -i path/input_file.json -o path/output_file' . PHP_EOL;
    die;
}

if (!file_exists($options['i'])) {
    echo 'Input file "' . $options['i'] . '" not exist or access forbidden' . PHP_EOL;
    die;
}

use Entity\Department;

$m = new Mustache_Engine([
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/template')
]);

$json_content = file_get_contents($options['i']);

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
$html = [];
$links = [];

foreach($tree as &$department) {
    $department->Childs = search_childs($department, $department_collection);
    $dep = new Department($department);
    $links[] = $dep->get_name();
    $html[] = $dep->get_html($m);
}

$output = null;

if (!isset($options['c']) || !(bool)$options['c']) {
    $output = $m->render('page', [
        'data' => $html,
        'links' => $links
    ]);
}
else {
    $output = $m->render('content', [
        'data' => $html,
        'links' => $links
    ]);
}

//echo $output;
file_put_contents($options['o'], $output);
copy(__DIR__ . '/tree.css', pathinfo($options['o'])['dirname'] . '/tree.css');