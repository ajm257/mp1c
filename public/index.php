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

    static public function getRecords($filename)
    {

        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $records[] = $data;
            }
            fclose($handle);
        }
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


        $html = "<table> $table </table>";

        return $html;


    }

    static public function returnHeader($header){

        $html = "<th> $header </th>" ;

        return $html;

    }

    static public function returnRow($row){

        $html = "<tr> $row </tr>";

        return $html;

    }

    static public function generateTable($records)
    {
        $html = '<html>';

        $html .= '<table>'; //start table

        $html .='<tr>';//header row

        foreach ($records[0] as $key => $value) {
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr>';

        foreach ($records as $key => $value) {

            $html .= '<tr>';
            foreach ($value as $key1 => $value1) {
                $html .= '<td>' . htmlspecialchars($value1) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table> </html>';
        return $html;
    }


}

class system {

    static public function printPage($table) {



        echo $table;
    }
}

