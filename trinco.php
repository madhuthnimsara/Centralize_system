<?php include('./class.inc.php');?>

   


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player with Notification</title>
    
</head>
<body>
    <h1>Trincomalee </h1>
    <div class="video-container">
    <?php
 

   
?>

    </div>
    
    <div class="notification" id="notification">

    <?php 







  $siteID = "1";
  echo $siteID;
  $response = file_get_contents("http://localhost/centralized/setVideo.php?website={$siteID}");

  $response=json_decode($response, true);
 if(!empty($response)){

    $elementValue = $response['element'];
    $errorValue = $response['error'];
    if(count($elementValue)){
      foreach($elementValue as $val){
          echo $val;
          }
    }
if(count( $errorValue)){
foreach($errorValue as $errval){
            echo $errval;
   }
}
     


}
  
  





    ?>

</body>
</html>
