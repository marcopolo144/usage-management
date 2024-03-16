<?php
include_once("../JULIANA/CLASS/Db.php");
class USER {
    private $username;
    private $email;
    private $password;
    private $photo;
    public $db;
    
public function __construct($username=null,$email=null,$password=null,$photo=null){
$this->username=$username;
$this->email=$email;
$this->photo=$photo;
$this->password=$password;
$this->db=new Database();
}


public function message($return){
    if($return==true){
        $message=array('status'=>200,'message'=>'save succefull');
    
    }else if($return==false){
        $message=array('status'=>201,'message'=>'Failed saved');
    }
    echo json_encode($message);
}
    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

     /**
     * Get the value of photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     */
    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }


    public function Validate(){
      if(empty($this->username) || empty($this->email) || empty($this->password) || empty($this->photo)){
        return json_encode(array('status'=>201,'message'=>'must be not empty'));
      }  
    }

    public function save($data,$file){
       
        $username=$data['username'];
        $email=$data['email'];
        $password=$data['password'];

        // traitement de la photo
        $file_name=$file['photo']['name'];
        $file_source=$file['photo']['tmp_name'];
        $file_size=$file['photo']['size'];

        $explod=explode(".",$file_name);
        $div=strtolower(end($explod));
        $file_unique=substr(md5(time()),0,10).'.'.$div;
        $upload="photos/".$file_unique;

        if(empty($username) || empty($email) || empty($password) || empty($file_name)){
            $message=array('status'=>201,'message'=>'Must be not empty');
            return $message;
        }else{
            $sql="INSERT INTO USERS(username,email,password,photo) VALUES('$username','$email','$password','$file_unique')";
            move_uploaded_file($file_source,$upload);
            $response=$this->db->insert($sql);
            if($response){
                $message=array('status'=>200,'message'=>'save succefull');
                return $message;
              }else{
                $message=array('status'=>201,'message'=>'save succefull');
                return $message;
              }
        }
       
                 

    }
    public function getUsernameEXIST($mot){
        return $this->db->select("SELECT * FROM USERS WHERE username='$mot'")->fetch(PDO::FETCH_ASSOC);
    }

    public function getUser(){
        $data=[];
        $sql="SELECT * FROM USERS ORDER BY id DESC";
        $response=$this->db->select($sql);
        foreach($response->fetchALL(PDO::FETCH_ASSOC) as $items){
            $data[]=$items;
        }
        return $data;
    }

    public function DeleteUser($id){
        return $this->db->select("DELETE FROM USERS WHERE id='$id'");
    }
}
