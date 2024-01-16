<?php 
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: error-404.php');
    exit;
}

if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en'; // Set default language
}

// Include the language file
$langFile = 'lang_' . $_SESSION['language'] . '.php';
include($langFile);

// Check if user is not logged in or not an admin

    ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>SHEMSY MASSAR </title>
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
                                <h3 class="page-title"><?php echo $lang['Bienvenue']; ?> <?php echo $_SESSION['username'];?>!</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><?php echo $lang['Tableau de bord']; ?></a></li>
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


$username=$_SESSION['username'];

    $sql = "SELECT count(etudiant.id) as etudiantCount
    FROM etudiant 
    INNER JOIN filiere ON filiere.id = etudiant.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiantCount = $row['etudiantCount'];
        
        
    }
   
}



?>
                                        <h6><?php echo $lang['Etudiants']; ?></h6>
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
                                        <h6><?php echo $lang['Formateurs']; ?></h6>
                                        <?php


$username=$_SESSION['username'];

$sql = "SELECT COUNT(DISTINCT formateur.id) AS formateurCount
        FROM formateur
        INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
        INNER JOIN filiere ON filiere.id = filiere_formateur.filiere_id
        INNER JOIN centre ON centre.id = filiere.centre_id
        INNER JOIN _admin ON _admin.centre_id = centre.id
        INNER JOIN _user ON _user.id = _admin.user_id
        WHERE _user.username = '$username'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formateurCount = $row['formateurCount'];
        
    }
   
}

$sql2 = "SELECT count(filiere.id) as filiereCount
FROM filiere 
INNER JOIN centre ON centre.id = filiere.centre_id
INNER JOIN _admin ON _admin.centre_id = centre.id
INNER JOIN _user ON _user.id = _admin.user_id
WHERE _user.username ='$username'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
while ($row2 = $result2->fetch_assoc()) {
    $filiereCount = $row2['filiereCount'];
    
}

}

?>
                                        <h3><?php echo $formateurCount;?></h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
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
                                        <h6><?php echo $lang['Filiéres']; ?></h6>
                                        <h3><?php echo $filiereCount;?></h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
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
                                        <h6><?php echo $lang['montant actuel']; ?></h6>
                                        <h3>******* MAD</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-04.svg" alt="Dashboard Icon">
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
                                        <h5 class="card-title"><?php echo $lang['Nombre d étudiants']; ?></h5>
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

$username = $_SESSION['username'];
$sql = "SELECT centre.id
        FROM centre
        INNER JOIN _admin ON _admin.centre_id = centre.id
        INNER JOIN _user ON _user.id = _admin.user_id
        WHERE _user.username = '$username'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$centerId = $row['id']; 

$sql = "SELECT COUNT(*) as count, gender FROM etudiant
 INNER JOIN filiere ON filiere.id = etudiant.filiere_id
INNER JOIN centre ON centre.id = filiere.centre_id
WHERE centre.id = $centerId
GROUP BY gender";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

$chartData = array();
foreach ($data as $row) {
    $chartData[$row['gender']] = $row['count'];
}

$chartJSON = json_encode($chartData);

    
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
                <h5 class="card-title"><?php echo $lang['Nombre des Formateurs']; ?></h5>
            </div>
            <div class="col-6">
                <ul class="chart-list-out">
                    <li><span class="circle-blue"></span>Homme</li>
                    <li><span class="circle-green"></span>Femme</li>
                 
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
    <canvas id="formateurChart"></canvas>
    </div>
</div>

</div>
 </div>
 <?php
$username = $_SESSION['username'];

        $sql1 = "SELECT COUNT(DISTINCT formateur.id) AS count, formateur.gender
        FROM formateur
        INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
        INNER JOIN filiere ON filiere.id = filiere_formateur.filiere_id
        INNER JOIN centre ON centre.id = filiere.centre_id
        INNER JOIN _admin ON _admin.centre_id = centre.id
        INNER JOIN _user ON _user.id = _admin.user_id
        WHERE _user.username = '$username'
        GROUP BY formateur.gender";
$result1 = mysqli_query($conn, $sql1);
$data1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

$chartData = array();
foreach ($data1 as $row1) {
    $chartData[$row1['gender']] = $row1['count'];
}

$jsonDataFormateur = json_encode($chartData);

    
?>

<script>
    // Get the JSON data
    var jsonDataF = <?php echo $jsonDataFormateur; ?>;

    // Chart configuration
    var config = {
        type: 'bar',
        data: {
            labels: ['Homme', 'Femme'],
            datasets: [{
                label: 'Sexe des formateurs',
                data: [jsonDataF['homme'], jsonDataF['femme']],
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
    var ctx1 = document.getElementById('formateurChart').getContext('2d');
    new Chart(ctx1, config);
</script>
      

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
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'
    ORDER BY archive_etudiant.id DESC
    LIMIT 3";
$result = $conn->query($sql);

// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}

?>
                                <h5 class="card-title"><?php echo $lang['Dernier étudiants abandonné']; ?></h5>
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

                        <div class="card flex-fill comman-shadow">
                            <div class="card-header d-flex align-items-center">
                            <h5 class="card-title"><?php echo $lang['Dernier étudiants abandonné']; ?></h5>
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
    <script src="assets/js/script.js"></script>
</body>

</html>

