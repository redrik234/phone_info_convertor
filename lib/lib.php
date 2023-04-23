<?php
function search_childs($parent, $department_collection) {
    $childs = [];
    foreach($department_collection as $department) {
        if (strcmp($department->HeadDepartment, $parent->DepartmentName) === 0) {
            $department->Childs = search_childs($department, $department_collection);
            $childs[$department->DepartmentName] = $department;
        }
    }

    return $childs;
}

