<?php
declare(strict_types=1);
namespace gradeManager;

use PHPUnit\Framework\TestCase;

class gradeManagerTests extends TestCase
{

    public function testCreateStudent()
    {
        $student = new student('CSMB', 1, 'Bob T', array(4));

        $this->assertNotEmpty($student->getListOfGrades());
        return $student;
    }

    public function testSetAverageCSMB()
    {
        $student = new student('CSMB', 2, 'Jane D', array(4,5,6));
        $student->setAverage();

        $this->assertEquals(5.5, $student->getAverage());
        return $student;
    }

    public function testSetAverageCSMBTwoGrades()
    {
        $student = new student('CSMB', 2, 'Jane D', array(4,5));
        $student->setAverage();

        $this->assertEquals(4.5, $student->getAverage());
        return $student;
    }

    public function testSetAverageOthers()
    {
        $student = new student('CST', 3, 'Jane D', array(4,5,6));
        $student->setAverage();

        $this->assertEquals(5, $student->getAverage());
        return $student;
    }

    public function testSetFinalResultCSM()
    {
        $student = new student('CSM', 4, 'Joe P', array(5,6,7));
        $student->setAverage();
        $student->setFinalResult();

        $this->assertEquals('Fail', $student->getFinalResult());
        return $student;
    }

    public function testSetFinalResultOther()
    {
        $student = new student('CSPV', 5, 'Joe P', array(5,6,7));
        $student->setAverage();
        $student->setFinalResult();

        $this->assertEquals('Pass', $student->getFinalResult());
        return $student;
    }
    
}