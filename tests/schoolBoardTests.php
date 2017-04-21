<?php
declare(strict_types=1);
namespace gradeManager;

use PHPUnit\Framework\TestCase;

class gradeManagerTests extends TestCase
{

    public function testCreateSchoolBoard()
    {
        $schoolBoard = new schoolBoard('CSMB', 'XML');

        $this->assertNotEmpty($schoolBoard->getName());
        return $schoolBoard;
    }

    public function testSetStudentsJSON()
    {
        $schoolBoard = new schoolBoard('CSM', 'JSON');
        $schoolBoard->setStudents('list.json');

        $this->assertNotEmpty($schoolBoard->getStudents());
        return $schoolBoard;
    }

    public function testSetStudentsXML()
    {
        $schoolBoard = new schoolBoard('CSMB', 'XML');
        $schoolBoard->setStudents('list.xml');

        $this->assertNotEmpty($schoolBoard->getStudents());
        return $schoolBoard;
    }
}