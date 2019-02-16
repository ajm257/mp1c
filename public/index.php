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

    }
}

class csv {

    static public function getRecords($filename) {

        $file = fopen($filename,"r"); //the data in the file

        while(! feof($file))
        {
            $record = fgetcsv($file);

            $records[] = recordFactory::create($record);
        }

        fclose($file);

        return $records;
    }
}

class record { //object instantiation

    public function __construct(Array $record = null) {

        print_r($record);
    }

}

class recordFactory { //what makes the object

    public static function create(Array $array = null) { //can be an empty object

        $record = new record($array);

        return $record;

}


}

/* class html {

    static public function generateTable($records) {

        $table = $records;

        return $table;
    }
}

class system {

    static public function printPage($page) {

        echo $page;
    }
} */

