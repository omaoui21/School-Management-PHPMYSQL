<?php

$host = 'localhost'; 
$dbName = 'massar'; 
$user = 'root'; 
$password = ''; 

// Establish database connection
$conn = new mysqli($host, $user, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['value'])) {
    $selectedValue = $_POST['value'];

   
    $sql = "SELECT * FROM module WHERE filiere_id = '$selectedValue'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $names = array();

        while ($row = $result->fetch_assoc()) {
            $names[] = $row;
        }

  
        foreach ($names as $name) {
            $moduleId = $name['id'];
            $moduleName = $name['nom_module'];
            $namesText .= "<option value=\"$moduleId\">$moduleName</option>";
        }
        // $namesText = "Names: " . implode(", ", $names);
        
        echo $namesText;
    } else {
        echo "No names found.";
    }
}


$conn->close();
?>