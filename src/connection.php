<?php

class Connection
{
    const USER='root';
    const PASSWORD='';
    const HOST='localhost';
    const DBNAME = 'transcript_2';

    public static function getConnection():PDO {
        try {
            $dsn = 'mysql:dbname='.self::DBNAME.";host=".self::HOST;
            return new PDO($dsn, self::USER, self::PASSWORD);

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        
    }
}
