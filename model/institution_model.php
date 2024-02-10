<?php

require_once "connection.php";

class Institution{

    private $id;
    private $name;
    private $description;
    private $registerDate;
    
    public function __construct($id,$name,$description,$registerDate) {
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->registerDate=$registerDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
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

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;
    }

    public function registerInstitution(){
        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="INSERT INTO institucion(name,description) VALUES(:name,:description)";
            $stmt=$pdo->prepare($query);
            
            $stmt->bindParam(":name",$this->name,PDO::PARAM_STR);
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

    public function updateInstitution(){
        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="UPDATE institucion SET name=:name,description=:description WHERE id=:id";
            $stmt=$pdo->prepare($query);
            
            $stmt->bindParam(":id",$this->id,PDO::PARAM_STR);
            $stmt->bindParam(":name",$this->name,PDO::PARAM_STR);
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

    public function loadTableInstitution(){

        try {
            $pdo=ConnectionMySQL::openConnection();
            $query="SELECT *,DATE_FORMAT(register_date,'%d/%m/%y %h:%i:%s %p') AS register_date FROM institucion";
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

    public function deleteInstitution(){
        try {
            if($this->id !== null){
                $pdo=ConnectionMySQL::openConnection();
                $query="DELETE FROM institucion WHERE id=:value";
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
            $query="SELECT *,DATE_FORMAT(register_date,'%d/%m/%y %h:%i:%s %p') AS register_date FROM institucion";
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
                $this->name=$result['name'];
                $this->description=$result['description'];
                $this->registerDate=$result['register_date'];
            }
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }
}