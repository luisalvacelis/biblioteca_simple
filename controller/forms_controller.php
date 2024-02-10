<?php
class FormsController{

    static public function ctrlLoadTableHome($item,$value){
        $response=FormsModel::loadTableHome($item,$value);
        return $response;
    }

    static public function ctrlLoadTableInstitution($value){
        $institution = new Institution(null,$value,null,null);
        return $institution->loadTableInstitution();
    }

    static public function ctrlLoadTableBook($value){
        $institution = new Book(null,null,$value,null,null,null);
        return $institution->loadTableBook();
    }
}