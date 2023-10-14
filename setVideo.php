<?php
global $errors;
$errors=[];
$element=[];
if ($_SERVER['REQUEST_METHOD'] == "GET"){
    $siteId=null;
    require_once __DIR__.'/class.inc.php';

    if(isset($_GET['website'])){
       if(strlen(trim($_GET['website']))){
           $siteid=(string)$_GET['website'];
       }else{
        $errors[]='Invalid website ID';
    }
    }else{
        $errors[]='website ID not found';
    }

    
    if(!count($errors)){
      $videos=$main->getVideos($siteid);
       if($videos){
         $element[]="<iframe src=\"https://www.youtube.com/embed/{$videos}\" width=\"800\" height=\"315\"></iframe>";
       }else{
        $videos=$main->getNotselected($siteid);
        $element[]="<iframe src=\"https://www.youtube.com/embed/{$videos}\" width=\"800\" height=\"315\"></iframe>";
       }
       
    }else{
        $errors[]="not counted errors";
    }

$response=['element'=>$element,'error'=>$errors,];
echo json_encode($response);

   
}
?>