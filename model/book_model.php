<?php

require_once "connection.php";

class Book{

    private $id;
    private $idInstitution;
    private $name;
    private $author;
    private $description;
    private $registerDate;
    
    public function __construct($id,$idInstitution,$name,$author,$description,$registerDate) {
        $this->id=$id;
        $this->idInstitution=$idInstitution;
        $this->name=$name;
        $this->author=$author;
        $this->description=$description;
        $this->registerDate=$registerDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdInstitution(){
        return $this->idInstitution;
    }

    public function getName() {
        return $this->name;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getRegisterDate() {
        return $this->registerDate;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdInstitution($idInstitution){
        $this->idInstitution=$idInstitution;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAuthor($author){
        $this->author=$author;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;
    }

    public function registerBook(){
        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="INSERT INTO libro(idBiblioteca,name,autor,description) VALUES(:idinstitution,:name,:author,:description)";
            $stmt=$pdo->prepare($query);

            if($this->idInstitution === -1){
                return false;
            }
            
            $stmt->bindParam(":idinstitution",$this->idInstitution,PDO::PARAM_INT);
            $stmt->bindParam(":name",$this->name,PDO::PARAM_STR);
            $stmt->bindParam(":author",$this->author,PDO::PARAM_STR);
            $stmt->bindParam(":description",$this->description,PDO::PARAM_STR);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function updateBook(){
        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="UPDATE libro SET idBiblioteca=:idBiblioteca,name=:name,autor=:author,description=:description WHERE id=:id";
            $stmt=$pdo->prepare($query);

            if($this->idInstitution !== -1){
                return false;
            }
            
            $stmt->bindParam(":id",$this->id,PDO::PARAM_INT);
            $stmt->bindParam(":idBiblioteca",$this->idInstitution,PDO::PARAM_INT);
            $stmt->bindParam(":name",$this->name,PDO::PARAM_STR);
            $stmt->bindParam(":author",$this->author,PDO::PARAM_STR);
            $stmt->bindParam(":description",$this->description,PDO::PARAM_STR);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function loadTableBook(){

        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="SELECT *,DATE_FORMAT(register_date,'%d/%m/%y %h:%i:%s %p') AS register_date FROM libro";
            if($this->name !== null){
                $query .=" WHERE name LIKE CONCAT('%', :value, '%') ORDER BY id ASC";
            }
            $stmt=$pdo->prepare($query);
            if($this->name !== null){
                $stmt->bindParam(":value",$this->name,PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function deleteBook(){
        try {
            if($this->id !== null){
                $pdo=ConnectionMySQL::openConnection();
                $query="DELETE FROM libro WHERE id=:value";
                $stmt=$pdo->prepare($query);
                $stmt->bindParam(":value",$this->id,PDO::PARAM_INT);
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public function searchByID(){
        try{
            $pdo=ConnectionMySQL::openConnection();
            $query="SELECT *,DATE_FORMAT(register_date,'%d/%m/%y %h:%i:%s %p') AS register_date FROM libro";
            if($this->id !== null){
                $query .=" WHERE id=:value";
            }
            $stmt=$pdo->prepare($query);
            if($this->id !== null){
                $stmt->bindParam(":value",$this->id,PDO::PARAM_INT);
            }
            $stmt->execute();
            $result=$stmt->fetch();
            if($result !== false){
                $this->id=$result['id'];
                $this->idInstitution=$result['idBiblioteca'];
                $this->name=$result['name'];
                $this->author=$result['autor'];
                $this->description=$result['description'];
                $this->registerDate=$result['register_date'];
            }
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }
}