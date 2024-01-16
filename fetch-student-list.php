<?php
session_start();
if (isset($_SESSION['sql_etudiant'])) {
    $fetchStudentListSql = $_SESSION['sql_etudiant'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}
// Connect to the database
include 'db/db.php';



// Execute the SQL statement
$result = mysqli_query($conn, $fetchStudentListSql);

// Check if any students are found
if (mysqli_num_rows($result) > 0) {
    $studentList = array();

    // Loop through the result set and add each student to the list
    while ($row = mysqli_fetch_assoc($result)) {
        $studentList[] = $row;
    }

    // Return the student list as a JSON response
    echo json_encode(array('students' => $studentList));
} else {
    // No students found
    echo json_encode(array('error' => 'No students found.'));
}

// Close the database connection
mysqli_close($conn);
?>
