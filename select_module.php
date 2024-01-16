<?php
session_start();

if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Retrieve user information from the database based on the session username
$username = $_SESSION['username'];

// Add your database query here to fetch the user information based on the username

// Retrieve the modules based on the selected filiere
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedFiliere = $_POST['filiere'];
    
    $sql = "SELECT *
    FROM module
    WHERE filiere_id ='$selectedFiliere'";

    $result = $conn->query($sql);

    $modules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
            
        }
       
    }   


    // Generate the module options HTML
    $optionsHtml = '';
    foreach ($modules as $module) {
        $optionsHtml .= "<option value=\"$module\">$module</option>";
    }

    // Send the module options HTML as the AJAX response
    echo $optionsHtml;
    exit();
}
?>