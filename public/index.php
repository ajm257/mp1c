<?php
/**
 * Created by PhpStorm.
 * User: ajm
 * Date: 2/14/19
 * Time: 9:08 PM
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

main::start("example.csv");

class main {

    static public function start ($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
        system::printPage($table);


        }
}

class csv {

    static public function getRecords($filename) {

        $file = fopen($filename,"r"); //the data in the file

        $fieldNames = array();

        $count = 0;

        while(! feof($file))
        {
            $record = fgetcsv($file);

            if($count == 0) {

                $fieldNames = $record;

            }else{

                $records[] = recordFactory::create($fieldNames, $record);


            }

            $count++;

        }

        fclose($file);

        return $records;
    }
}

class record { //object instantiation

    public function __construct(Array $fieldNames = null, $values = null) {

        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);

        }


    }

    public function returnArray() {
        $array = (array) $this;

        return $array;
    }

    public function createProperty($name, $value) {

        $this->{$name} = $value;
    }
}

class recordFactory { //what makes the object

    public static function create(Array $fieldNames = null, Array $values = null) { //can be an empty object

        $record = new record($fieldNames, $values);

        return $record;

}


}

class html
{

    static public function generateTable($records)
    {

        $html = '<table>'; //start table

        $html .= '<tr>'; //header row

        foreach ($records[0] as $key => $value) {
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr>';

        $html .= '</table>';
        return $html;
    }

}

class system {

    static public function printPage($table) {

        echo $table;
    }
}

