<?php
/**
 * Created by PhpStorm.
 * User: ajm
 * Date: 2/14/19
 * Time: 9:08 PM
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

$filename = 'example.csv';
$program = new main($filename);

class main {

    public function __construct($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
        system::printPage($table);


        }
}

class csv
{

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

class recordFactory
{ //what makes the object

    public static function create(Array $fieldNames = null, Array $values = null)
    { //can be an empty object

        $record = new record($fieldNames, $values);

        return $record;

    }


}

class html
{
    static public function returnTable($table) {


        $htmlTable = '';

        $htmlTable .= '<head><title>My Mini Project IS601</title><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script></head><body>';

        $htmlTable .= '<table class="table table-striped">';

        return $htmlTable;


    }

    static public function returnHeader($header){

        $htmlHeader = '' ;

        $htmlHeader .='<tr>';//header row

        foreach ($header as $key => $value) {
            $htmlHeader .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $htmlHeader .= '</tr>';

        return $htmlHeader;

    }

    static public function returnRow($recordsRow){

        $htmlRow = '';

        foreach ($recordsRow as $key => $value) {

            $htmlRow .= '<tr>';
            foreach ($value as $key1 => $value1) {
                $htmlRow .= '<td>' . htmlspecialchars($value1) . '</td>';
            }
            $htmlRow .= '</tr>';
        }

        return $htmlRow;

    }

    static public function generateTable($records)
    {


        $html = self::returnTable($records);

        $html .= self::returnHeader($records[0]);

        $html .= self::returnRow($records);

        $html .= '</table></body> </html>';
        return $html;
    }


}

class system {

    static public function printPage($table) {



        echo $table;
    }
}

