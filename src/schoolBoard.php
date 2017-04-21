<?php
declare(strict_types=1);
namespace gradeManager;

require_once("student.php");

class schoolBoard
{
    private $name;
    private $resultFormat;
    private $students = [];

    public function __construct($name, $resultFormat)
    {
        $this->ensureName($name);
        $this->ensureResultFormat($resultFormat);

        $this->name = $name;
        $this->resultFormat = $resultFormat;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getResultFormat()
    {
        return $this->resultFormat;
    }

    public function getStudents()
    {
        return $this->students;
    }

    public function setStudents($file)
    {
        $string = file_get_contents($file);

        if ($this->resultFormat == 'JSON') {
            $studentsArr = json_decode($string, TRUE);
        } else {
            $xml = simplexml_load_string($string, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $studentsArr = json_decode($json, TRUE);
        }

        foreach ($studentsArr as $std) {
            $student = new student($std['schoolBoard'], $std['studentId'], $std['name'], $std['listOfGrades']);
            $this->students[] = $student;
        }
    }

    public function sendResults($file)
    {
        foreach ($this->getStudents() as $student) {
            $results[] = array(
                'schoolBoard' => $student->getSchoolBoard(),
                'studentId' => $student->getStudentId(),
                'name' => $student->getName(),
                'listOfGrades' => $student->getListOfGrades(),
                'average' => $student->getAverage(),
                'finalResult' => $student->getFinalResult()
            );

        }

        if ($this->resultFormat == 'JSON') {
            $result = json_encode($results);
        } else {
            $xml = new \SimpleXMLElement('<root/>');
            $this->array_to_xml($results,$xml);
            $result = $xml->asXML();
        }

        if (!is_writable($file)) {
            throw new \Exception('File ' . $file .' not writable');
        }

        file_put_contents($file, $result);
    }

    // Implement two school boards, CSM and CSMB
    public function ensureName($name)
    {
        if (empty($name)) {
            throw new \Exception('Implement school boards with names');
        }
    }

    // Each student result, either XML or JSON
    public function ensureResultFormat($resultFormat)
    {
        if ($resultFormat != 'XML' && $resultFormat != 'JSON') {
            throw new \Exception('Each student result, either XML or JSON');
        }
    }

    // function to convert array to xml from the internet
    public function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            if( is_array($value) ) {
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }
}