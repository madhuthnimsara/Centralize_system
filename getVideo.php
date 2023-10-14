<?php

$con = mysqli_connect('localhost', 'root', '', 'preschool');

// SQL query to retrieve data
$sql = "SELECT * FROM videos";
$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
    // Fetch and format data
    while ($row = $result->fetch_assoc()) {
        $websiteIdSerialized = trim($row['websiteId']);
        $websiteIdUnserialized = unserialize($websiteIdSerialized);
        
        // Print the unserialized data
        echo "Video ID: " . $row['id'] . "<br>";
        echo "Link: " . $row['link'] . "<br>";
        echo "Website IDs: ";
        print_r( $websiteIdUnserialized);
        echo "<br><br>";
    }
} else {
    echo "No data found.";
}

mysqli_close($con);

?>
