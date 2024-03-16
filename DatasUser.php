<?php
include('CLASS/USER.php');
$user=new USER();
if(isset($_POST['action']) && $_POST['action']=='saveUser'){
  $response=$user->save($_POST,$_FILES);
  echo json_encode($response);
}


if(isset($_POST['mot']) && $_POST['mot']!=''){
  $response=$user->getUsernameEXIST($_POST['mot']);
  echo json_encode($response);
}

if(isset($_POST['action']) && $_POST['action']=='getUser'){
  $response=$user->getUser();
  echo json_encode(array('data'=>$response));
}


if(isset($_POST['action']) && $_POST['action']=='delete'){
  $rep=$user->DeleteUser($_POST['id']);
  $response=array('status'=>200,'message'=>'delete succefully');
  echo json_encode($response);
}




