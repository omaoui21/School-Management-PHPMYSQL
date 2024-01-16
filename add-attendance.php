<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'formateur') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';


$username=$_SESSION['username'];
    $sql = "SELECT formateur.id
            FROM formateur
            INNER JOIN _user ON _user.id = formateur.user_id
            WHERE _user.username = '$username'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $formateurId = $row['id'];

    // Get the modules taught by the formateur
    $sql = "SELECT module.id, module.nom_module
    FROM module
    INNER JOIN module_formateur ON module_formateur.module_id = module.id
    WHERE module_formateur.formateur_id = $formateurId";
    $_SESSION['sql_module']=$sql;
    $result = mysqli_query($conn, $sql);
    $moduleOptions = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $moduleId = $row['id'];
        $moduleName = $row['nom_module'];
        $moduleOptions .= '<option value="' . $moduleId . '">' . $moduleName . '</option>';
    }

    // Retrieve the etudiant data
    $sql = "SELECT id, nom, prenom FROM etudiant WHERE filiere_id IN (SELECT filiere_id FROM filiere_formateur WHERE formateur_id = $formateurId)";
    $result = mysqli_query($conn, $sql);
    $_SESSION['sql_etudiant']=$sql;
    $etudiantOptions = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $etudiantId = $row['id'];
        $etudiantNom = $row['nom'];
        $etudiantPrenom = $row['prenom'];
        $etudiantOptions .= '<option value="' . $etudiantId . '">' . $etudiantNom . ' ' . $etudiantPrenom . '</option>';
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $moduleID = $_POST['module_id'];
        $etudiantID = $_POST['etudiant_id'];
        $date = $_POST['date'];
        $reason = $_POST['reason'];

        // Insert the absence record into the database
        $sql = "INSERT INTO absence (date, reason, module_id, etudiant_id) VALUES ('$date', '$reason', $moduleID, $etudiantID)";

        if (mysqli_query($conn, $sql)) {
            header('Location:absence.php?success=ajouter');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo "Invalid request.";
    }
    ?>
    



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Etudiants</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar/navbar.php' ?>


<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row">
<div class="col">
<h3 class="page-title">Ajouter attendance</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Dashboard</a></li>
<li class="breadcrumb-item active">Ajouter attendance</li>
</ul>
</div>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
<div class="container">
        <h3>Ajouter Attendance</h3>
        
        <form id="attendanceForm">
            <!-- Display the list of students -->
            <ul id="studentList">
                <!-- The student list will be populated dynamically -->
            </ul>
            
            <!-- Module select -->
            <select id="moduleSelect" class="form-control" required>
                <!-- The module options will be populated dynamically -->
            </select>
            <br>
            
            <!-- Button to submit attendance -->
            <button id="submitAttendanceBtn" class="btn btn-primary" type="submit">Submit Attendance</button>
        </form>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Submit button click event
        $('#attendanceForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            var moduleId = $('#moduleSelect').val();
            
            // Create an array to store the messages
            var messages = [];
            
            // Create an array to store the AJAX requests
            var requests = [];
            
            // Loop through the student list and get attendance status
            $('#studentList li').each(function() {
                var etudiantId = $(this).data('student-id');
                var status = $(this).find('select').val();
                
                // Send AJAX request to mark attendance and add it to the requests array
                requests.push(markAttendance(etudiantId, moduleId, status));
            });
            
     
    $.when.apply($, requests).done(function() {
    // Extract the response arguments from the AJAX requests
    var responses = Array.from(arguments).map(function(response) {
        return response[0];
    });

    responses.forEach(function(response) {
        if (response && response.success) {
            messages.push(response.success); // Store the success message
        } else if (response && response.error) {
            messages.push(response.error); // Store the error message
        }
    });
                
                // Clear the inputs and select elements
                $('#moduleSelect').val('');
                $('#studentList li select').val('');
                
            
    displayMessages(messages);
            });
            
            // Prevent form submission
            return false;
        });
   // Function to display the messages
// Function to display the messages
function displayMessages(messages) {
    // Display the messages in an alert dialog
    if (messages.length > 0) {
        alert(messages.join('\n'));
    }
}



        
        // Function to mark attendance
        function markAttendance(etudiantId, moduleId, status) {
            // Send AJAX request to mark attendance
            return $.ajax({
                url: 'mark-attendance.php',
                type: 'POST',
                data: {
                    studentId: etudiantId,
                    moduleId: moduleId,
                    status: status
                },
                dataType: 'json'
            });
        }
        
 
        // Load the student list
        loadStudentList();
        
        // Fetch module options
        fetchModuleOptions();
        
        // Function to load the student list
        function loadStudentList() {
            // AJAX request to fetch the student list
            $.ajax({
                url: 'fetch-student-list.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.hasOwnProperty('students')) {
                        var studentList = response.students;
                        $('#studentList').empty();
                        
                        $.each(studentList, function(index, student) {
                            var listItem = $('<li>');
                            listItem.data('student-id', student.id); // Use data() instead of attr()
                            listItem.text(student.nom + ' ' + student.prenom+ ' :');
                            
                            var selectElement = $('<select>').prop('required', true);
                            selectElement.append($('<option>').attr('value', '').text('sélectionner la présence').prop('selected', true).prop('disabled', true));
                            selectElement.append($('<option>').attr('value', 'Present').text('Present'));
                            selectElement.append($('<option>').attr('value', 'Absent').text('Absent'));

                            listItem.append(selectElement);

                            $('#studentList').append(listItem);
                        });
                    } else {
                        $('#studentList').html('<li>Error: Failed to fetch student list.</li>');
                    }
                },
                error: function() {
                    $('#studentList').html('<li>Error: Failed to fetch student list.</li>');
                }
            });
        }
        
        // Function to fetch module options
        function fetchModuleOptions() {
    // AJAX request to fetch module options
    $.ajax({
        url: 'fetch-module-options.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response)) {
                var moduleOptions = response;
                $('#moduleSelect').empty();
                
                // Create the selected and disabled option
                var defaultOption = $('<option>')
                    .attr('value', '')
                    .text('Select a Matière')
                    .prop('selected', true)
                    .prop('disabled', true);
                
                $('#moduleSelect').append(defaultOption);
                
                moduleOptions.forEach(function(option) {
                    var optionElement = $('<option>')
                        .attr('value', option.value)
                        .text(option.label);
                    
                    $('#moduleSelect').append(optionElement);
                });
            } else {
                $('#moduleSelect').empty().append($('<option>').attr('value', '').text('Error: Failed to fetch Matière options.'));
            }
        },
        error: function() {
            $('#moduleSelect').html('<option value="">Error: Failed to fetch Matière options.</option>');
        }
    });
}


    });
    </script>
</div>
</div>
</div>
</div>
</div>
</div>

</div>




<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/script.js"></script>

</body>
</html>