#!/usr/bin/php
<?php
declare(strict_types=1);
namespace gradeManager;

require_once("src/schoolBoard.php");

// 'CSM', 'JSON'
$sb1 = new schoolBoard('CSM', 'JSON');
$sb1->setStudents('list.json');

foreach ($sb1->getStudents() as $student) {
    $student->setAverage();
    $student->setFinalResult();
}

$sb1->sendResults('test.json');


// 'CSMB', 'XML'
$sb2 = new schoolBoard('CSMB', 'XML');
$sb2->setStudents('list.xml');

foreach ($sb2->getStudents() as $student) {
    $student->setAverage();
    $student->setFinalResult();
}

$sb2->sendResults('test.xml');
