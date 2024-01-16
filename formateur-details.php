<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$username=$_SESSION['username'];
include 'db/db.php';

if (isset($_GET['id'])) {
    // Retrieve the formateur ID from the URL parameter
    $id = $_GET['id'];

    $query = "SELECT formateur.id, formateur.nom AS nom_formateur, formateur.prenom AS prenom_formateur, formateur.image, formateur.email,
    formateur.telephone, formateur.date_de_naissance,formateur.gender, formateur.adresse, nom_filiere
    FROM formateur 
    INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
    INNER JOIN filiere ON filiere.id = filiere_formateur.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username = '$username'
    AND formateur.id = '$id'";

    $result = mysqli_query($conn, $query);
  
    if (mysqli_num_rows($result) > 0) {
        $row2 = mysqli_fetch_assoc($result);
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Preskool - Formateur Details</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

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
<h3 class="page-title">Formateur Details</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur.php">Formateur</a></li>
<li class="breadcrumb-item active">Formateur Details</li>
</ul>
</div>
</div>
</div>
</div>
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-md-12">
<div class="about-info">
<h4>Profile <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h4>
</div>
<div class="student-profile-head">
<div class="profile-bg-img">
<img src="assets/img/profile-bg.jpg" alt="Profile">
</div>
<div class="row">
<div class="col-lg-4 col-md-4">
<div class="profile-user-box">
<div class="profile-user-img">
<img alt="User" src="<?php echo $row2['image']; ?>">
<div class="form-group students-up-files profile-edit-icon mb-0">
<div class="uplod d-flex">
<label class="file-upload profile-upbtn mb-0">
<i class="feather-edit-3"></i><input type="file">
</label>
</div>
</div>
</div>

<div class="names-profiles">
<h4><?php echo $row2['prenom_formateur']; ?> <?php echo $row2['nom_formateur']; ?></h4>
<h5>Formateur</h5>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="student-personals-grp">
<div class="card">
<div class="card-body">
<div class="heading-detail">
<h4>Personal Details :</h4>
</div>
<div class="personal-activity">
<div class="personal-icons">
<i class="feather-user"></i>
</div>
<div class="views-personal">
<h4>Name</h4>
<h5><?php echo $row2['prenom_formateur']; ?> <?php echo $row2['nom_formateur']; ?></h5>
</div>
</div>
<div class="personal-activity">
<div class="personal-icons">
<img src="assets/img/icons/buliding-icon.svg" alt="">
</div>
<div class="views-personal">
<h4>Filiere </h4>
<h5><?php echo $row2['nom_filiere']; ?></h5>
</div>
</div>
<div class="personal-activity">
<div class="personal-icons">
<i class="feather-phone-call"></i>
</div>
<div class="views-personal">
<h4>Mobile</h4>
<h5><?php echo $row2['telephone']; ?></h5>
</div>
</div>
<div class="personal-activity">
<div class="personal-icons">
<i class="feather-mail"></i>
</div>
<div class="views-personal">
<h4>Email</h4>
<h5><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d4bebbb194b3b9b5bdb8fab7bbb9"><?php echo $row2['email']; ?></a></h5>
</div>
</div>
<div class="personal-activity">
<div class="personal-icons">
<i class="feather-user"></i>
</div>
<div class="views-personal">
<h4>Gender</h4>
<h5><?php echo $row2['gender']; ?></h5>
</div>
</div>
<div class="personal-activity">
<div class="personal-icons">
<i class="feather-calendar"></i>
</div>
<div class="views-personal">
<h4>Date of Birth</h4>
<h5><?php echo $row2['date_de_naissance']; ?></h5>
</div>
</div>
<div class="personal-activity">
<div class="personal-icons">
<i class="feather-italic"></i>
</div>
<div class="views-personal">
<h4>Language</h4>
<h5>French</h5>
</div>
</div>
<div class="personal-activity mb-0">
<div class="personal-icons">
<i class="feather-map-pin"></i>
</div>
<div class="views-personal">
<h4>Address</h4>
<h5><?php echo $row2['adresse']; ?></h5>
</div>
</div>
</div>
</div>
</div>

<div class="student-personals-grp">
<div class="card mb-0">
<div class="card-body">
<div class="heading-detail">
<h4>Skills:</h4>
</div>
<div class="skill-blk">
<div class="skill-statistics">
<div class="skills-head">
<h5>Photoshop</h5>
<p>90%</p>
</div>
<div class="progress mb-0">
<div class="progress-bar bg-photoshop" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
<div class="skill-statistics">
<div class="skills-head">
<h5>Code editor</h5>
<p>75%</p>
</div>
<div class="progress mb-0">
<div class="progress-bar bg-editor" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
<div class="skill-statistics mb-0">
<div class="skills-head">
<h5>Illustrator</h5>
<p>95%</p>
</div>
<div class="progress mb-0">
<div class="progress-bar bg-illustrator" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<footer>
<p>Copyright © 2023 JassaRich.</p>
</footer>

</div>

</div>
<?php
} else {
  // If the ID is not present in the URL, display an error message or redirect the user
  echo 'Invalid Formateur ID.';
}
}?>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>