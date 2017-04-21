<?php
declare(strict_types=1);
namespace gradeManager;

class student
{
    private $schoolBoard;
    private $studentId;
    private $name;
    private $listOfGrades = [];
    private $average;
    private $finalResult;

    public function __construct($schoolBoard, $studentId, $name, $listOfGrades)
    {
        $this->ensureSchoolBoard($schoolBoard);
        $this->ensureStudentId($studentId);
        $this->ensureName($name);
        $this->ensureOneToFourGrades($listOfGrades);

        $this->schoolBoard = $schoolBoard;
        $this->studentId = $studentId;
        $this->name = $name;
        $this->listOfGrades = $listOfGrades;
    }


    public function getSchoolBoard()
    {
        return $this->schoolBoard;
    }

    public function getListOfGrades()
    {
        return $this->listOfGrades;
    }

    public function getStudentId()
    {
        return $this->studentId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAverage()
    {
        return $this->average;
    }

    public function getFinalResult()
    {
        return $this->finalResult;
    }

    public function setAverage()
    {
        // CSMB discards the lowest grade, if you have more than 2 grades
        if ($this->getSchoolBoard() == "CSMB" && count($this->listOfGrades) > 2) {
            sort($this->listOfGrades, SORT_NUMERIC);
            array_shift($this->listOfGrades);
        }

        $this->average = array_sum($this->listOfGrades) / count($this->listOfGrades);
    }

    public function setFinalResult()
    {
        // CSM considers pass if the average is bigger or equal to 7 and fail otherwise.
        if ($this->getSchoolBoard() == "CSM") {
            if ($this->getAverage() >= 7) {
                $this->finalResult = "Pass";
            } else {
                $this->finalResult = "Fail";
            }
        } else {
            // I made the assumption here that other school boards look at bigger or equal to 5 to pass
            if ($this->getAverage() >= 5) {
                $this->finalResult = "Pass";
            } else {
                $this->finalResult = "Fail";
            }
        }
    }

    // A student can have 1 to 4 grades
    private function ensureOneToFourGrades($listOfGrades)
    {
        if (count($listOfGrades) < 1 || count($listOfGrades) > 4) {
            throw new \Exception('A student can have 1 to 4 grades');
        }
    }

    // will contain the student id
    public function ensureStudentId($studentId)
    {
        if (empty($studentId)) {
            throw new \Exception('will contain the student id');
        }
    }

    // will contain the student name
    public function ensureName($name)
    {
        if (empty($name)) {
            throw new \Exception('will contain the student name');
        }
    }

    // A student is registered with only one school board
    public function ensureSchoolBoard($schoolBoard)
    {
        if (empty($schoolBoard)) {
            throw new \Exception('A student is registered with only one school board');
        }
    }
}