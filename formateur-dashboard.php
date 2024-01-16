<?php 
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'formateur') {
    header('Location: error-404.php');
    exit;
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Formateur</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/plugins/simple-calendar/simple-calendar.css">

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
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Home</a></li>
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
$sql = "SELECT COUNT(module.id) AS module_count
FROM module
INNER JOIN module_formateur ON module_formateur.module_id = module.id
INNER JOIN formateur ON formateur.id = module_formateur.formateur_id
INNER JOIN _user ON _user.id = formateur.user_id
WHERE _user.username = '$username'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$moduleCount = $row['module_count'];
?>
<h6>Total Matières</h6>
<h3><h3><?php echo $moduleCount;?></h3></h3>
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


$username=$_SESSION['username'];

    $sql = "SELECT COUNT(DISTINCT etudiant.id) AS etudiantCount 
    FROM etudiant
    INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = etudiant.filiere_id
    INNER JOIN formateur ON formateur.id = filiere_formateur.formateur_id
    INNER JOIN _user ON _user.id = formateur.user_id
    WHERE _user.username = '$username' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiantCount = $row['etudiantCount'];
        
        
    }
   
}



?>

<h6>Nombre total d'étudiants</h6>
<h3><?php echo $etudiantCount;?></h3>
</div>
<div class="db-icon">
<img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
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


$username=$_SESSION['username'];

$sql = "SELECT formateur.id
        FROM formateur
        INNER JOIN _user ON _user.id = formateur.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$formateurId = $row['id'];

// Retrieve the count of courses for the formateur
$sql = "SELECT COUNT(*) AS course_count
        FROM course
        INNER JOIN module_formateur ON module_formateur.module_id = course.module_id
        WHERE module_formateur.formateur_id = $formateurId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$courseCount = $row['course_count'];



?>

<h6>Total des leçons</h6>
<h3><?php echo $courseCount; ?></h3>
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


$username=$_SESSION['username'];

$sql = "SELECT formateur.id
        FROM formateur
        INNER JOIN _user ON _user.id = formateur.user_id
        WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$formateurId = $row['id'];

// Retrieve the count of courses for the formateur
$sql = "SELECT sum(heure) AS module_count
   FROM module_to_module
    INNER JOIN module ON module.id = module_to_module.module_id
    INNER JOIN module_formateur ON module_formateur.module_id = module.id
    WHERE module_formateur.formateur_id = $formateurId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$module_count = $row['module_count'];

?>
<h6>Heures totales</h6>
<h3><?php echo $module_count; ?> h</h3>
</div>
<div class="db-icon">
<img src="assets/img/icons/teacher-icon-03.svg" alt="Dashboard Icon">
</div>
</div>
</div>
</div>
</div>
</div>


<div class="row">
<div class="col-md-12 col-lg-6">

                        <div class="card card-chart">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title">Nombre d'étudiants</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="chart-list-out">
                                            <li><span class="circle-blue"></span>garçon</li>
                                            <li><span class="circle-green"></span>fille</li>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                <div class="card-body">
                              <canvas id="studentChart"></canvas>
                            </div>
                        </div>

                    </div>
                    
<?php

$sql = "SELECT formateur.id
        FROM formateur
        INNER JOIN _user ON _user.id = formateur.user_id
        WHERE _user.username = '$username'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$formateurId = $row['id'];

$sql1 = "SELECT  COUNT(DISTINCT etudiant.id)  as count, etudiant.gender
        FROM etudiant
        INNER JOIN filiere ON filiere.id = etudiant.filiere_id
        INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = filiere.id
        WHERE filiere_formateur.formateur_id = $formateurId
        GROUP BY etudiant.gender";
$result1 = mysqli_query($conn, $sql1);
$data1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

$chartData1 = array();
foreach ($data1 as $row1) {
    $chartData1[$row1['gender']] = $row1['count'];
}

$chartJSON = json_encode($chartData1);
   
?>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the JSON data
    var chartData = <?php echo $chartJSON; ?>;

    // Chart configuration
    var config = {
        type: 'bar',
        data: {
            labels: ['garçon', 'fille'],
            datasets: [{
                label: 'Sexe de étudiant',
                data: [chartData['homme'], chartData['femme']],
                backgroundColor: ['#FFB84C', '#87CBB9'],
                borderColor: ['#FFB84C', '#87CBB9'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    };

    // Create the chart
    var ctx = document.getElementById('studentChart').getContext('2d');
    new Chart(ctx, config);
</script>
<div class="col-md-12 col-lg-6">

                        <div class="card card-chart">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h3 class="card-title">Programme d'Année</h3>
                                    </div>
                                 
                                </div>
                            </div>
                                <div class="card-body">
                                <?php
                                
                                $username=$_SESSION['username'];
    $sql = "SELECT formateur.id
            FROM formateur
            INNER JOIN _user ON _user.id = formateur.user_id
            WHERE _user.username = '$username'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $formateurId = $row['id'];

    // Get the modules taught by the formateur
    $sql = "SELECT module_to_module.id, module_to_module.nom_mudole,module_to_module.heure,module.nom_module
    FROM module_to_module
    INNER JOIN module ON module.id = module_to_module.module_id
    INNER JOIN module_formateur ON module_formateur.module_id = module.id
    WHERE module_formateur.formateur_id = $formateurId";
    $result = $conn->query($sql);
    $filieres = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filieres[] = $row;
            
        }
       
    }   
    
           foreach ($filieres as $filiere) : ?>
<h6>
Module : <?php echo $filiere['nom_mudole']; ?>
 , <?php echo $filiere['heure']; ?>h
            <br>  
</h6>
                           

                    <?php endforeach; ?>
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

$username=$_SESSION['username'];

    $sql = "SELECT archive_etudiant.id,archive_etudiant.nom ,archive_etudiant.prenom ,archive_etudiant.image,
    archive_etudiant.email,archive_etudiant.telephone,archive_etudiant.date_de_naissance,archive_etudiant.adresse,nom_filiere
    FROM archive_etudiant 
    INNER JOIN filiere ON filiere.id = archive_etudiant.filiere_id
    INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = archive_etudiant.filiere_id
    INNER JOIN formateur ON formateur.id = filiere_formateur.formateur_id
    INNER JOIN _user ON _user.id = formateur.user_id
    WHERE _user.username ='$username'
    GROUP BY archive_etudiant.id";
$result = $conn->query($sql);

// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}
?>

<h5 class="card-title">Dernier étudiants abandonné</h5>
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
                                        

<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Filiere</th>
</tr>
</thead>
<tbody>
<?php foreach ($etudiants as $etudiant) : ?>
<tr>

<td>
<h2 class="table-avatar">
<a href="formateur-details.php" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?php echo$etudiant['image']; ?>" alt="Formateur Image" width="200"alt="User Image">
<a href="formateur-details.php"><?php echo $etudiant['nom']; ?></a>
</h2>
</td>
<td><?php echo $etudiant['prenom']; ?></td>
<td><?php echo $etudiant['email']; ?></td>
<td><?php echo $etudiant['nom_filiere']; ?></td>

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

$sql = "SELECT formateur.id
FROM formateur
INNER JOIN _user ON _user.id = formateur.user_id
WHERE _user.username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$formateurId = $row['id'];

// Retrieve all courses with the same module as the formateur
$sql = "SELECT exam.id, exam.exam_date, exam.exam_time, exam.exam_title, exam.exam_description, module.nom_module
FROM exam
INNER JOIN module_formateur ON module_formateur.module_id = exam.module_id
INNER JOIN module ON module.id = exam.module_id
WHERE module_formateur.formateur_id = $formateurId
ORDER BY exam.id DESC
LIMIT 3";

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
<th>Date de l'examen</th>
<th>Temps d'examen</th>
<th>Titre de l'examen</th>
<th>Matière</th>
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
<p>Copyright © 2023 ZAKARIAE && ISSAM.</p>
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
