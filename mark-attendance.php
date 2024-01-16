<?php
// Connect to the database
include 'db/db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the student ID and attendance status from the POST data
    $studentId = $_POST['studentId']; // <-- Make sure the parameter name matches
    $moduleId = $_POST['moduleId']; // <-- Make sure the parameter name matches
    $status = $_POST['status'];

    // Debugging statements
    error_log('studentId: ' . $studentId);
    error_log('moduleId: ' . $moduleId);
    error_log('status: ' . $status);

    // Prepare the SQL statement to insert attendance data
    $insertAttendanceSql = "INSERT INTO attendance (etudiant_id, module_id, status, date) VALUES (?, ?, ?, NOW())";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $insertAttendanceSql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'iis', $studentId, $moduleId, $status);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Success message
        $response = array('success' => 'Attendance marked successfully.');
        echo json_encode($response);
    } else {
        // Error message
        $response = array('error' => 'Failed to mark attendance.');
        echo json_encode($response);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Invalid request method
    $response = array('error' => 'Invalid request method.');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($conn);
?>
