<?php
SESSION_START();
class main {
    private $host='localhost';
    private $user='root';
    private $password='';
    private $database='preschool';
    private $dbconnect=false;



    //constructor

    public function __construct(){
        if(!$this->dbconnect)
        {
            $con=mysqli_connect($this->host,$this->user,$this->password,$this->database);
            if($con->connect_error)
            {
                die('could not connected'.$con->connect_error);
            }else{
                $this->dbconnect=$con;
            }
        }
    }


    public function insertVideoLink($POST) {
      $link = $POST['link'];
        @$selectedData = serialize($POST['data']);
        
        // Use preg_match to extract the video ID from the YouTube URL
        if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $link, $matches)) {
            $video_id = $matches[1];
          
            
            @$selectedData = mysqli_real_escape_string($this->dbconnect, $selectedData);
    
             $insertQuery = "INSERT INTO videos(link,websiteId) VALUES ('$link','  $selectedData')";
             $insertResult = mysqli_query($this->dbconnect, $insertQuery);
    
                if ($insertResult) {
                 
                    $_SESSION['message'] = 'Insert successfully';
                }
              
            }else {
            $_SESSION['message'] = 'Invalid YouTube URL'; // Handle the case where the URL format is invalid
        }
    }


    public function getVideos($siteId) {
        $sql = "SELECT link
        FROM videos
        WHERE id = (SELECT MAX(id) FROM videos)
          AND FIND_IN_SET('$siteId', websites) > 0;
        ";
        $result = mysqli_query($this->dbconnect, $sql);
    
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Fetch the first row (you can modify this if you expect multiple rows)
                $row = mysqli_fetch_array($result);
                return $row['link'];
            } else {
                // No rows were found
                return false;
            }
        } else {
            // Handle the SQL query error here
            return false;
        }
    }
    

    public function schoolDetails($POST){
        global $errors, $response;
        $errors = [];
        $response = [];
        
        $zone = mysqli_real_escape_string($this->dbconnect, $POST['zone']);
        $sclName = mysqli_real_escape_string($this->dbconnect, $POST['schoolName']);
        $schId = mysqli_real_escape_string($this->dbconnect, $POST['schoolID']);
        $trimmedSclName = trim($zone);
        if ($trimmedSclName == 'select') {
            $response[] = 'please select the school';
        } else {
            $sql = "INSERT INTO schools(school_id, school_name, zone) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->dbconnect, $sql);
        
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sss', $schId, $sclName, $zone);
                if (mysqli_stmt_execute($stmt)) {
                    $response[] = 'successfully';
                } else {
                    $errors[] = 'not successful';
                }
                mysqli_stmt_close($stmt);
            } else {
                $errors[] = 'Statement preparation failed';
            }
        }
        
        return ['errors' => $errors, 'response' => $response];
        

    }


    public function getNotselected($webid){
        $sql="SELECT * FROM videos
        WHERE FIND_IN_SET('$webid', websites) > 0
        ORDER BY id DESC
        LIMIT 1;
        ";

        $result=mysqli_query($this->dbconnect,$sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Fetch the first row (you can modify this if you expect multiple rows)
                $row = mysqli_fetch_array($result);
                return $row['link'];
            } else {
                // No rows were found
                return false;
            }
        } else {
            // Handle the SQL query error here
            return false;
        }

    }

  
      
}

?>