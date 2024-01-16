<?php
session_start();
if (isset($_SESSION['sql_module'])) {
    $fetchModuleOptionsSql = $_SESSION['sql_module'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}
// Connect to the database and fetch the module options
include 'db/db.php';



// Execute the SQL statement
$result = mysqli_query($conn, $fetchModuleOptionsSql);

// Check if any module options are found
if (mysqli_num_rows($result) > 0) {
    $moduleOptions = array();

    // Loop through the result set and add each module option to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $moduleId = $row['id'];
        $moduleName = $row['nom_module'];
        $moduleOptions[] = array('value' => $moduleId, 'label' => $moduleName);
    }

    // Send the module options as JSON response
    echo json_encode($moduleOptions);
} else {
    // No module options found
    echo json_encode(array());
}

// Close the database connection
mysqli_close($conn);
?>
