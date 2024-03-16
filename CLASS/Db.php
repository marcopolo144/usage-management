<?php
class Database{
      private $dns="mysql:host=localhost:3306;dbname=JULIANA";
      private $user='root';
      private $password ='';
      public $link;
      public $error;
     
public function __construct(){
    $this->getConnection();
} 

public function getConnection(){
$this->link=new PDO($this->dns,$this->user,$this->password);
if(!$this->link){
  $this->error="Failed connection ";
  return false;
 }
}
public function insert($sql){
  $result=$this->link->query($sql) or die($this->link->error.__LINE__);
 if($result){
  return $result;
  }else{
   return false;
  }
 }
public function select($sql){
 $result=$this->link->query($sql) or die($this->link->error.__LINE__);
if($result){
 return $result;
 }else{
  return false;
 }
}


public function AutoUpdate($spentday,$restday,$dateupdate,$codep){
  $sql="UPDATE Person SET spentday='$spentday',restday='$restday',dateupdate='$dateupdate' where codep='$codep'";
  $response=$this->link->query($sql);
  return true;

}
 public function getData(){
   $sql="SELECT * FROM Person";
   $response=$this->link->query($sql);
   foreach($response->fetchAll(PDO::FETCH_ASSOC) as $row){
    if(date('Y-m-d') != $row['dateupdate']){
      $day=$row['day'];
      $spentday=$row['spentday']+1;
      $restday=$day-$spentday;
      $codep=$row['codep'];
      $dateupdate=date('Y-m-d');
       $this->AutoUpdate($spentday,$restday,$dateupdate,$codep);
    }
   }
 }


}


$a=new Database();
$a->getData();
//echo json_encode($a->AutoUpdate());