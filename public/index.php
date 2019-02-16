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

        print_r($records);
    }
}

class csv {

    static public function getRecords($filename) {

        $file = fopen($filename,"r");

        while(! feof($file))
        {
            $record = fgetcsv($file);

            $records[] = $record;
        }

        fclose($file);

        return $records;
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

