<?php require_once __DIR__.'/class.inc.php';?>
<?php 
if(isset($_POST['submit'])){
    $insertSchool=$main->schoolDetails($_POST);
    $response=$insertSchool['response'];
    $error=$insertSchool['errors']; 

    if(!empty($error)){
        foreach($error as $err){
            echo $error . "\n";
        }
    }


    if(!empty($response)){
        foreach($response as $res){
            echo $res. "\n";
        }
    }
    } 
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Zone, School Name, and School ID Selection</title>
</head>
<body>
    <h1>Select a Zone, Add a School Name</h1>
    <form method="post" action="">
        <label for="zone">Select Zone:</label>
        <select name="zone" id="zone">
            <option value='select'>Select the school</option>
            <option value="Estern Province">Estern Province</option>
            <option value="Central Provinve">Central Provinve</option>
            <!-- Add more options as needed -->
        </select>
        <br>
        <label for="schoolName">School Name:</label>
        <input type="text" name="schoolName" id="schoolName" required >
        <br>
        <label for="schoolID">School ID:</label>
        <input type="text" name="schoolID" id="schoolID" required >
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
