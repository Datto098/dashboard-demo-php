<?php
class Protype extends Db{
    //Viet phuong thuc lay ra tat ca san pham moi nhat
    function getAllProtypes(){
        $sql = self::$connection->prepare("SELECT * 
        FROM protypes");
        $sql->execute();//return an object
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items; //return an array
    }
    
}