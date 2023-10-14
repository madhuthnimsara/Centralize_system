<?php
// Establish a MySQLi database connection (you should have this already)
$mysqli = new mysqli("localhost", "root", "", "preschool");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL query
$sql = "SELECT link FROM videos WHERE JSON_SEARCH(websites, 'all', '1') IS NOT NULL";

// Execute the query
$result = $mysqli->query($sql);

if ($result) {
    // Fetch and process the results
    while ($row = $result->fetch_assoc()) {
        echo "Link: " . $row['link'] . "<br>";
    }
    // Close the result set
    $result->close();
} else {
    echo "Error: " . $mysqli->error;
}

// Close the database connection
$mysqli->close();
?>
