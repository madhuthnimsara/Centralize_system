<!DOCTYPE html>
<html>
<head>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
$host = "localhost";
$username = "root";
$password = '';
$database = "preschool";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Define the zones you want to display
$zones = ['Estern Province', 'Central Provinve', 'North Province'];

echo '<div class="container">';
echo '<form class="my-3" action="" method="post">';
echo '<div class="form-check">';
echo '<input class="form-check-input" type="checkbox" id="selectAllSchools">';
echo '<label class="form-check-label" for="selectAllSchools"> Select All Schools</label>';
echo '</div>';
echo '<input type="text" class="form-control" name="url" placeholder="enter url" required/>';
// Loop through the zones and retrieve the schools for each zone
foreach ($zones as $zone) {
    $sql = "SELECT * FROM schools WHERE zone = :zone";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':zone', $zone, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $schools = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<p class='font-weight-bold'>$zone Zone:</p>";
        echo '<div class="form-check">';
        echo '<input class="form-check-input select-zone" type="checkbox" data-zone="' . $zone . '">';
        echo '<label class="form-check-label"> Select All Schools in Zone</label>';
        echo '</div>';
        foreach ($schools as $school) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="selected_schools[]" value="' . $school['school_id'] . '" data-zone="' . $zone . '">';
            echo '<label class="form-check-label">' . $school['school_name'] . '</label>';
            echo '</div>';
        }
    }
}

echo '<button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>';
echo '</form>';
echo '</div>';
?>
<script>
// JavaScript to select all checkboxes when "Select All Schools" is clicked
const selectAllSchoolsCheckbox = document.querySelector('#selectAllSchools');
selectAllSchoolsCheckbox.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_schools[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// JavaScript to select all checkboxes within a specific zone when "Select All Schools in Zone" is clicked
const selectZoneCheckboxes = document.querySelectorAll('.select-zone');
selectZoneCheckboxes.forEach(selectZoneCheckbox => {
    selectZoneCheckbox.addEventListener('change', function() {
        const zone = this.closest('form').querySelectorAll('input[type="checkbox"][name="selected_schools[]"][data-zone="' + selectZoneCheckbox.getAttribute('data-zone') + '"]');
        zone.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
});
</script>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




<?php 
global $errors;
$errors=[];

if(isset($_POST['submit'])){
    if(isset($_POST['selected_schools']) && count($_POST['selected_schools']) > 0){
        $selectedSchools=[];
        if(isset($_POST['selected_schools'])){
            foreach($_POST['selected_schools'] as $selectschool){
                $selectedSchools[]=$selectschool;
            }
        }

        $pdo = new PDO("mysql:host=localhost;dbname=preschool", "root", "");

        // Data to be inserted
        $link = trim($_POST['url']);
        $schools = implode(',', $selectedSchools);

        if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $link, $matches)) {
            $video_id = $matches[1];

            $sql = "INSERT INTO videos(link, websites) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$video_id, $schools]);
            
            if ($result) {
                $errors[] = "Successful";
            } else {
                $errors[] = "Unsuccessful";
            }
        } else {
            $errors[] = "Invalid";
        }
    } else {
        $errors[] = "Please select at least one school to insert data";
    }
}

// Display errors
foreach ($errors as $message) {
    echo $message . "<br>";
}
?>
