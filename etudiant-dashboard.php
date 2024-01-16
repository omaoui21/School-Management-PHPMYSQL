<?php 
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'etudiant') {
    header('Location: error-404.php');
    exit;
}

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>SHEMSY MASSAR</title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
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
<div class="col-sm-12">
<div class="page-sub-header">
<h3 class="page-title">Welcome <?php echo $_SESSION['username'];?>!</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="etudiant-dashboard.php">Home</a></li>
<li class="breadcrumb-item active"><?php echo $_SESSION['role'];?></li>
</ul>
</div>
</div>
</div>
</div>


<div class="row">
<div class="col-xl-3 col-sm-6 col-12 d-flex">
<div class="card bg-comman w-100">
<div class="card-body">
<div class="db-widgets d-flex justify-content-between align-items-center">
<div class="db-info">

<?php
$username = $_SESSION['username'];
$sql = "SELECT etudiant.id
        FROM etudiant
        INNER JOIN _user ON _user.id = etudiant.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$etudiantId = $row['id'];

// Retrieve the count of courses for the etudiant
$sql = "SELECT COUNT(*) AS courseCount
        FROM course
        INNER JOIN module ON module.id = course.module_id
        INNER JOIN filiere ON filiere.id = module.filiere_id
        INNER JOIN etudiant ON etudiant.filiere_id = filiere.id
        WHERE etudiant.id = $etudiantId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$courseCount = $row['courseCount'];
?>

<h6>Tous les cours</h6>
<h3><?php echo $courseCount; ?></h3>
</div>
<div class="db-icon">
<img src="assets/img/icons/teacher-icon-01.svg" alt="Dashboard Icon">
</div>
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12 d-flex">
<div class="card bg-comman w-100">
<div class="card-body">
<div class="db-widgets d-flex justify-content-between align-items-center">
<div class="db-info">
<?php
// Retrieve the etudiant's ID
$username = $_SESSION['username'];
$sql = "SELECT etudiant.id
        FROM etudiant
        INNER JOIN _user ON _user.id = etudiant.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$etudiantId = $row['id'];

// Retrieve the count of modules for the etudiant
$sql = "SELECT COUNT(DISTINCT module.id) AS moduleCount
        FROM module
        INNER JOIN filiere ON filiere.id = module.filiere_id
        INNER JOIN etudiant ON etudiant.filiere_id = filiere.id
        WHERE etudiant.id = $etudiantId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$moduleCount = $row['moduleCount'];
?>
<h6>Nombre des modules</h6>
<h3><?php echo $moduleCount; ?></h3>
</div>
<div class="db-icon">
<img src="assets/img/icons/teacher-icon-02.svg" alt="Dashboard Icon">
</div>
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12 d-flex">
<div class="card bg-comman w-100">
<div class="card-body">
<div class="db-widgets d-flex justify-content-between align-items-center">
<div class="db-info">

<?php
// Retrieve the etudiant's ID
$sql = "SELECT etudiant.id
        FROM etudiant
        INNER JOIN _user ON _user.id = etudiant.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$etudiantId = $row['id'];

// Retrieve the count of exams for the etudiant
$sql = "SELECT COUNT(*) AS examCount
        FROM exam
        INNER JOIN module ON module.id = exam.module_id
        INNER JOIN filiere ON filiere.id = module.filiere_id
        INNER JOIN etudiant ON etudiant.filiere_id = filiere.id
        WHERE etudiant.id = $etudiantId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$examCount = $row['examCount'];
?>

<h6>Examens suivi</h6>
<h3><?php echo $examCount; ?></h3>
</div>
<div class="db-icon">
<img src="assets/img/icons/student-icon-01.svg" alt="Dashboard Icon">
</div>
</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 col-12 d-flex">
<div class="card bg-comman w-100">
<div class="card-body">
<div class="db-widgets d-flex justify-content-between align-items-center">
<div class="db-info">

<?php
// Retrieve the etudiant's ID
$sql = "SELECT etudiant.id
        FROM etudiant
        INNER JOIN _user ON _user.id = etudiant.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$etudiantId = $row['id'];

// Retrieve the count of notes for the etudiant
$sql = "SELECT COUNT(*) AS noteCount
        FROM note
        INNER JOIN module ON module.id = note.module_id
        INNER JOIN filiere ON filiere.id = module.filiere_id
        WHERE note.etudiant_id = $etudiantId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$noteCount = $row['noteCount'];
?>

<h6>Examens terminés</h6>
<h3><?php echo $noteCount; ?></h3>
</div>
<div class="db-icon">
<img src="assets/img/icons/student-icon-02.svg" alt="Dashboard Icon">
</div>
</div>
</div>
</div>
</div>
</div>





</div>

<div class="row">
                    <div class="col-xl-6 d-flex">

                        <div class="card flex-fill student-space comman-shadow">
                            <div class="card-header d-flex align-items-center">

                            <?php

$username = $_SESSION['username'];

// Retrieve the etudiant ID for the given username
$sql = "SELECT etudiant.id
        FROM etudiant
        INNER JOIN _user ON _user.id = etudiant.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$etudiantId = $row['id'];

// Retrieve the last course added for the etudiant
$sql = "SELECT course.nom, course.description, course.file_course, module.nom_module
        FROM course
        INNER JOIN module_formateur ON module_formateur.module_id = course.module_id
        INNER JOIN formateur ON formateur.id = module_formateur.formateur_id
        INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
        INNER JOIN etudiant ON etudiant.filiere_id = filiere_formateur.filiere_id
        INNER JOIN module ON module.id = course.module_id
        WHERE etudiant.id = $etudiantId
        ORDER BY course.id DESC
        LIMIT 1";


$result = $conn->query($sql);

// Fetch all formateurs
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
        
    }
   
}
?>

<h5 class="card-title">Dernier cours ajouté</h5>
<ul class="chart-list-out student-ellips">
                                    <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        class="table star-student table-hover table-center table-borderless table-striped">
                                        <thead class="thead-light">
                                        <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Module</th>
                <th>Course</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($courses as $course) : ?>
            <tr>
                <td><?php echo $course['nom']; ?></td>
                <td><?php echo $course['description']; ?></td>
                <td><?php echo $course['nom_module']?></td>
                <td><a href="<?php echo $course['file_course']; ?>" target="_blank">Télécharger <i class="fas fa-download"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                                </div>
                            </div>
                        </div>

                    </div>
    
                    <div class="col-xl-6 d-flex">

                        <div class="card flex-fill student-space comman-shadow">
                            <div class="card-header d-flex align-items-center">

    <?php

$username=$_SESSION['username'];

// Retrieve the etudiant ID for the given username
$sql = "SELECT etudiant.id
        FROM etudiant
        INNER JOIN _user ON _user.id = etudiant.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$etudiantId = $row['id'];

// Retrieve the last exam added for the etudiant
$sql = "SELECT exam.exam_date, exam.exam_time, exam.exam_title, exam.exam_description, module.nom_module
        FROM exam
        INNER JOIN module_formateur ON module_formateur.module_id = exam.module_id
        INNER JOIN formateur ON formateur.id = module_formateur.formateur_id
        INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
        INNER JOIN etudiant ON etudiant.filiere_id = filiere_formateur.filiere_id
        INNER JOIN module ON module.id = exam.module_id
        WHERE etudiant.id = $etudiantId
        ORDER BY exam.id DESC
        LIMIT 1";


$result = $conn->query($sql);

// Fetch all formateurs
$exams = [];
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$exams[] = $row;

}

}
?>

<h5 class="card-title">Dernier exam ajouté</h5>
<ul class="chart-list-out student-ellips">
                                    <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        class="table star-student table-hover table-center table-borderless table-striped">
                                        <thead class="thead-light">
                                        <tr>
<th>Exam date</th>
<th>Exam time</th>
<th>Exam title</th>
<th>Module</th>
</tr>
</thead>
<tbody>
<?php foreach ($exams as $exam) : ?>
<tr>
<td><?php echo $exam['exam_date']; ?></td>
<td><?php echo $exam['exam_time']; ?></td>
<td><?php echo $exam['exam_title']; ?></td>
<td><?php echo $exam['nom_module']?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
        </div>
    </div>
</div>



                    </div>
                </div>
<footer>
<p>Copyright © 2023 ZAKARIAE.</p>
</footer>

</div>

</div>


<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>

<script src="assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
<script src="assets/js/calander.js"></script>

<script src="assets/js/circle-progress.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>
