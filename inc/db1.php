<?php


class con extends SQLite3
{

    public function __construct()
    {
        $this->open('my_work.db');
    }

    public function command($connection, $cmd)
    {
        return $connection->query($cmd);
    }
public function myData($result)
{
    $myArray = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $myArray[] = $row;
    }

    return $myArray;
}

}


$DB = new con ;

