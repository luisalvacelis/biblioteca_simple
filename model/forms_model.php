<?php

/*use FTP\Connection;*/

require_once "connection.php";

class FormsModel{

    static public function loadTableHome($item=null,$value=null){
        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="SELECT l.id,i.name as name_biblioteca,l.name as name_libro,l.autor,l.description, 
            DATE_FORMAT(l.register_date,'%d/%m/%y %h:%i:%s %p') AS register_date FROM libro l 
            INNER JOIN institucion i ON i.id=l.idBiblioteca";
            if($item !== null && $value !==null){
                $query .=" WHERE $item LIKE CONCAT('%', :value, '%') ORDER BY l.id ASC";
            }
            $stmt=$pdo->prepare($query);
            if($item !== null && $value !==null){
                $stmt->bindParam(":value",$value,PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}