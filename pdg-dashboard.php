<?php 
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pdg') {
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
<li class="breadcrumb-item"><a href="pdg-dashboard.php">Home</a></li>
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
$sql = "SELECT COUNT(centre.id) AS center_count
FROM centre";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$center_count = $row['center_count'];
?>
<h6>Total Centres</h6>
<h3><h3><?php echo $center_count ?></h3></h3>
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


$sql = "SELECT COUNT(_user.id) AS user_count
FROM _user";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$user_count = $row['user_count'];



?>

<h6>Total d'utilisateurs</h6>
<h3><?php echo $user_count ?></h3>
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


// $username=$_SESSION['username'];

// $sql = "SELECT formateur.id
//         FROM formateur
//         INNER JOIN _user ON _user.id = formateur.user_id
//         WHERE _user.username = '$username'";
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);
// $formateurId = $row['id'];

// // Retrieve the count of courses for the formateur
// $sql = "SELECT COUNT(*) AS course_count
//         FROM course
//         INNER JOIN module_formateur ON module_formateur.module_id = course.module_id
//         WHERE module_formateur.formateur_id = $formateurId";
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);
// $courseCount = $row['course_count'];



?>

<h6>Total des leçons</h6>
<h3>1</h3>
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
<h6>Total Hours</h6>
<h3>15/20</h3>
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
                        <h5 class="card-title">Le nombre de filières pour chaque centre</h5>
                    </div>
                    <div class="col-6">
                        <ul class="chart-list-out">
                            <li><span class="circle-blue"></span>Nombre de Fillières</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="filiereChart"></canvas>
            </div>
        </div>
    </div>

    <?php
    $sql = "SELECT centre.nom AS centre_name, COUNT(filiere.id) AS filiere_count
            FROM centre
            LEFT JOIN filiere ON filiere.centre_id = centre.id
            GROUP BY centre.id";
    $result = mysqli_query($conn, $sql);
    $chartData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $centerName = $row['centre_name'];
        $filiereCount = $row['filiere_count'];

        // Add the center and filiere count to the chart data
        $chartData[] = array(
            'center' => $centerName,
            'filiereCount' => $filiereCount
        );
    }

    // Convert the chart data to JSON format
    $chartJSON = json_encode($chartData);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get the JSON data
        var chartData = <?php echo $chartJSON; ?>;

        // Extract the center names and filiere counts from the chart data
        var centerNames = chartData.map(function(data) {
            return data.center;
        });

        var filiereCounts = chartData.map(function(data) {
            return data.filiereCount;
        });

        // Chart configuration
        var config = {
            type: 'bar',
            data: {
                labels: centerNames,
                datasets: [{
                    label: 'Nombre de Fillières',
                    data: filiereCounts,
                    backgroundColor: '#FFB84C',
                    borderColor: '#FFB84C',
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
        var ctx = document.getElementById('filiereChart').getContext('2d');
        new Chart(ctx, config);
    </script>


<div class="col-md-12 col-lg-6">
    <div class="card card-chart">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h5 class="card-title">Le nombre d'étudiants pour chaque centre</h5>
                </div>
                <div class="col-6">
                    <ul class="chart-list-out">
                        <li><span class="circle-blue"></span>Nombre des étudiants</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
        <canvas id="etudiantChart"></canvas>
        </div>
    </div>
</div>
</div>
<?php
$sql = "SELECT centre.nom AS centre_name, COUNT(etudiant.id) AS etudiant_count
FROM centre
LEFT JOIN filiere ON filiere.centre_id = centre.id
LEFT JOIN etudiant ON etudiant.filiere_id = filiere.id
GROUP BY centre.id";

$result = mysqli_query($conn, $sql);
$chartData = array();

while ($row = mysqli_fetch_assoc($result)) {
$centreName = $row['centre_name'];
$etudiantCount = $row['etudiant_count'];

// Add the centre and etudiant count to the chart data
$chartData[] = array(
'centreName' => $centreName,
'etudiantCount' => $etudiantCount
);
}

// Convert the chart data to JSON format
$chartJSON = json_encode($chartData);

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the JSON data
    var chartData = <?php echo $chartJSON; ?>;

// Extract the center names and etudiant counts from the chart data
var centreName = chartData.map(function(data) {
    return data.centreName;
});

var etudiantCounts = chartData.map(function(data) {
    return data.etudiantCount;
});

// Chart configuration
var config = {
    type: 'bar',
    data: {
        labels: centreName,
        datasets: [{
            label: 'Nombre des étudiants',
            data: etudiantCounts,
            backgroundColor: '#FFB84C',
            borderColor: '#FFB84C',
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
var ctx = document.getElementById('etudiantChart').getContext('2d');
new Chart(ctx, config);
</script>



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
