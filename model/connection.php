<?php

class ConnectionMySQL{
    static public function openConnection(){
        try {
            $link=new PDO("mysql:host=localhost;dbname=biblioteca","root","123123");
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->exec('set names utf8');
            return $link;
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}