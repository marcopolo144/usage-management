<?php
include_once("../JULIANA/CLASS/Db.php");
class Person{
    private $namep;
    private $firstnamep;
    private $birthdayp;
    private $datecreated;
    private $dateleave;
    public $db;

    public function __construct(){
        $this->db=new Database();  
    }

    public function getCode(){
        $sql="SELECT * FROM Person ORDER BY codep DESC Limit 1";
        $requet=$this->db->select($sql);
        $response=$requet->fetch(PDO::FETCH_ASSOC);
        if($response){
            return $response['codep'];
        }else{
            return "juliana";
        }
    }

    
    public function getAll($limit,$fin){
        $sql="SELECT * FROM Person ORDER BY codep DESC LIMIT $limit,$fin";
        $requet=$this->db->select($sql);
        $response=$requet->fetchAll(PDO::FETCH_ASSOC);
       return $response;
    }


    public function getRestday($campo=null,$d1,$d2){
      $result=[];
      if($campo!=""){
        $sql="SELECT * FROM Person WHERE codep LIKE '%$campo%' OR namep LIKE '%$campo%' AND  restday  BETWEEN  '$d1' AND '$d2'";

      }else{
        $sql="SELECT * FROM Person WHERE restday  BETWEEN  '$d1' AND '$d2'";

      }
      $requet=$this->db->select($sql);
      $response=$requet->fetchAll(PDO::FETCH_ASSOC);
      foreach($response as $item){
        $result[]=$item;
      }
       return $result;
  }


    public function getTotal(){
        $sql="SELECT * FROM Person";
        $response=$this->db->select($sql);
        return $response->rowCount();
    }


    public function getSearch($champ){
        $sql="SELECT * FROM Person WHERE codep LIKE '%$champ%'  OR namep LIKE '%$champ%' OR firstnamep LIKE '%$champ%'";
        $requet=$this->db->select($sql);
        $response=$requet->fetchAll(PDO::FETCH_ASSOC);
       return $response;
    }

    public function getSearchUnique($champ){
        $sql="SELECT * FROM Person WHERE codep ='$champ'  OR namep ='$champ' OR firstnamep ='$champ'";
        $requet=$this->db->select($sql);
        $response=$requet->fetch(PDO::FETCH_ASSOC);
       return $response;
    }

  public function save($data,$file){
    $codep=$data["codep"];
    $namep=$data["namep"];
    $firstnamep=$data["firstnamep"];
    $birthdayp=$data["birthdayp"];
    $datecreated=$data["datecreated"];
    
    $dateleave=date("Y-m-d",strtotime($datecreated.'+30 days'));
 //tratiement de la photo

 $file_name=$file["photo"]["name"];
 $source=$file["photo"]["tmp_name"];
 $file_size=$file["photo"]["size"];

 //explode photo
 $div=explode(".",$file_name);
 $end=strtolower(end($div));
 $image_unique=substr(md5(time()),0,10).'.'.$end;
 $uplode="IMAGES/".$image_unique;

 //verify type image
 $containerimage=array('pnp','jpg','gif','webcom','webp');

/* if(!in_array($div,$containerimage)){
    $mesg=array('status'=>201,'message'=>'no permited');
    return $mesg;
 }else 
 **/
 if($file_size > 10548900){
    $mesg=array('status'=>201,'message'=>'image is too big');
    return $mesg; 
 }else if(empty($codep) || empty($namep) || empty($firstnamep) || empty($birthdayp) || empty($datecreated) || empty($file_name)){
    $mesg=array('status'=>201,'message'=>'remplissez tous les champ');
    return $mesg; 
 }else{
    $sql="INSERT INTO Person(codep,namep,firstnamep,birthdayp,photo,datecreated,dateleave)
          VALUES('$codep','$namep','$firstnamep','$birthdayp','$image_unique','$datecreated','$dateleave')";
    $response=$this->db->select($sql);
    if($response){
        move_uploaded_file($source,$uplode);
        $mesg=array('status'=>200,'message'=>'saved succefully');
        return $mesg;  
    }else{
        $mesg=array('status'=>201,'message'=>'Failed save');
      
        return $mesg; 
    }
 }
  }



  public function saveImage($data,$file){

 //tratiement de la photo
 $desp=$data['desp'];
 $file_name=$file["photo"]["name"];
 $source=$file["photo"]["tmp_name"];
 $file_size=$file["photo"]["size"];

 //explode photo
 $div=explode(".",$file_name);
 $end=strtolower(end($div));
 $image_unique=substr(md5(time()),0,10).'.'.$end;
 $uplode="carousels_photos/".$image_unique;
 move_uploaded_file($source,$uplode);
 //verify type image
 $containerimage=array('pnp','jpg','gif','webcom','webp');

/* if(!in_array($div,$containerimage)){
    $mesg=array('status'=>201,'message'=>'no permited');
    return $mesg; or 1=1 
 }else 
 **/
$sql="INSERT INTO Images(name,source,desp)
VALUES('$image_unique','$uplode','$desp')";
$response=$this->db->select($sql);

$mesg=array('status'=>200,'message'=>'saved succefully');
return $mesg;  

  }

  public function getImage(){
    $result=array();
    $sql="SELECT * FROM Images ORDER BY id DESC LIMIT 5";
    $response=$this->db->select($sql);
    foreach($response->fetchAll(PDO::FETCH_ASSOC) as $row){
      $result[]=$row;
     }
    
    return $result;
  }

  public function Edit($codep){
    $sql="SELECT * FROM Person WHERE codep='$codep' ";
    $requet=$this->db->select($sql);
    $response=$requet->fetch(PDO::FETCH_ASSOC);
   return $response;
}


public function update($data,$file){
    $codep=$data["codep"];
    $namep=$data["namep"];
    $firstnamep=$data["firstnamep"];
    $birthdayp=$data["birthdayp"];
    $datecreated=$data["datecreated"];

    $dateleave=date("Y-m-d",strtotime($datecreated.'+30 days'));

 //tratiement de la photo et ses criteres pour des raisons dordres securitaires

 $file_name=$file["photo"]["name"];
 $source=$file["photo"]["tmp_name"];
 $file_size=$file["photo"]["size"];

 //explode photo
 $div=explode(".",$file_name);
 $end=strtolower(end($div));
 $image_unique=substr(md5(time()),0,10).'.'.$end;
 $uplode="IMAGES/".$image_unique;

 //verify type image
 $containerimage=array('pnp','jpg','gif','webcom','webp');

/* if(!in_array($div,$containerimage)){
    $mesg=array('status'=>201,'message'=>'no permited');
    return $mesg;
 }else 
 **/
 if($file_size > 10548900){
    $mesg=array('status'=>201,'message'=>'image is too big');
    return $mesg; 
 }else if(empty($codep) || empty($namep) || empty($firstnamep) || empty($birthdayp) || empty($datecreated)){
    $mesg=array('status'=>201,'message'=>'remplissez tous les champ');
    return $mesg; 
 }else if(empty($file_name)){
    $sql="UPDATE Person SET namep='$namep',firstnamep='$firstnamep', birthdayp='$birthdayp', datecreated='$datecreated', dateleave='$dateleave' WHERE codep='$codep'";
    $response=$this->db->select($sql);
    if($response){
      
        $mesg=array('status'=>200,'message'=>'saved succefully');
        return $mesg;  
      }else{
        $mesg=array('status'=>201,'message'=>'Failed save');
      
        return $mesg; 
      }
   
 }else{
    $sql="UPDATE Person SET namep='$namep', firstnamep='$firstnamep', birthdayp='$birthdayp', photo='$image_unique',datecreated='$datecreated', dateleave='$dateleave' WHERE codep='$codep'";
    $response=$this->db->select($sql);
if($response){
    move_uploaded_file($source,$uplode);
  $mesg=array('status'=>200,'message'=>'saved succefully');
  return $mesg;  
}else{
  $mesg=array('status'=>201,'message'=>'Failed save');

  return $mesg; 
}
 }
  }

  public function Delete($codep){
    $sql="DELETE FROM Person WHERE codep='$codep' ";
    $response=$this->db->select($sql);
    if($response->rowCount()==1){
        $mesg=array('status'=>200,'message'=>'Delete successfully');
        return $mesg; 
    }else{
        $mesg=array('status'=>201,'message'=>'Failed Deleted');
        return $mesg; 
    }
}
}
