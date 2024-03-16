<?php
include('CLASS/Person.php');
$person=new Person();
//get lastid
if(isset($_POST['action']) && $_POST['action']=='getCode'){
  $result=$person->getCode();
   if($result=="juliana"){
    $code="P00001";
   }else{
    $explode=str_replace("P","",$result);
    $increase=$explode + 1;
    $chaine=str_pad($increase,5,0,STR_PAD_LEFT);
    $code="P".$chaine;
   }

   echo $code;
}
//save
if(isset($_POST['action']) && $_POST['action']=='savePerson'){
  $response=$person->save($_POST,$_FILES);
  print_r(json_encode($response));
}


//save image
if(isset($_POST['action']) && $_POST['action']=='saveImage'){
  $response=$person->saveImage($_POST,$_FILES);
  print_r(json_encode($response));
}
 

//get image
if(isset($_POST['action']) && $_POST['action']=='getImage'){
$result=[];
  $response=$person->getImage();
  foreach($response as $item){
   $result[]=$item;
 
  }

  echo json_encode($result);
}
 

//get all
if(isset($_POST['action']) && $_POST['action']=='AllPerson'){
  $champ=null;
  $limit=12;
  $pagination="";
  $pagination.='<nav aria-label="Page navigation example">';
  $pagination.='<ul class="pagination">';

// check search
   if(isset($_POST['champ']) && !empty($_POST['champ'])){
    $champ=$_POST['champ'];
   }
//check pagination
   if(isset($_POST['page']) && is_numeric($_POST['page'])){
    $page=$_POST['page'];
   }else{
    $page=1;
   }

   $total=$person->getTotal();

   $fin=($page-1)*$limit;

   $npage=ceil($total/$limit);

   for($i=1;$i<$npage;$i++){
     $pagination.='<li class="page-item page" page='.$i.'><a class="page-link">'.$i.'</a></li>';
   }
   $pagination.='</nav>';
   $pagination.='</ul>';
   if($champ){
    $response=$person->getSearch($champ);
   }else{
    $response=$person->getAll($fin,$limit);
   }

   print_r(json_encode(array('data'=>$response,'pagination'=>$pagination)));
  
  }
//edit
  if(isset($_POST['action']) && $_POST['action']=='Edit'){
      $response=$person->Edit($_POST['codep']);
      print_r(json_encode($response));
    }

    //update
if(isset($_POST['action']) && $_POST['action']=='updatePerson'){
    $response=$person->update($_POST,$_FILES);
    print_r(json_encode($response));
  }
  
  //DELETE
  if(isset($_POST['action']) && $_POST['action']=='Delete'){
    $response=$person->Delete($_POST['codep']);
    print_r(json_encode($response));
  }


  if(isset($_POST['action']) && $_POST['action']=='getRestDay'){
   $response="";
    if(isset($_POST["campo"]) && $_POST["campo"]!=""){
      $response=$person->getRestday($_POST["campo"],0,28);
    }else{
      $response=$person->getRestday('',0,28);

    }
    print_r(json_encode(array('data'=>$response)));
  }
 

  if(isset($_POST['action']) && $_POST['action']=='Search'){
    $response=$person->getSearchUnique($_POST['text']);
    print_r(json_encode($response));
  }

