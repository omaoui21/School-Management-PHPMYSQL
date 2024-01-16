<?php 
session_start();
include 'db/db.php';

if (isset($_SESSION['username'])) {

    echo "Loading...";

    $username = $_SESSION['username'];

// Prepare and execute the SQL query
$query = ("SELECT * FROM _user WHERE username = '$username'");
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
  
    $row = mysqli_fetch_assoc($result);
    $role = $row['role'];
    $id = $row['id'];
    if ($role == 'admin') {
        $query1 = ("SELECT * FROM _admin inner join _user on _admin.user_id='$id'");
    } else if ($role == 'formateur') {
        $query1 = ("SELECT * FROM formateur inner join _user on formateur.user_id='$id'");
    } else if ($role == 'etudiant') {
        $query1 = ("SELECT * FROM etudiant inner join _user on etudiant.user_id='$id'");
    } else if ($role == 'pdg') {
        $query1 = ("SELECT * FROM pdg inner join _user on pdg.user_id='$id'");
    }
    $result1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($result1);
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
<div class="col">
<h3 class="page-title">Profile</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
<li class="breadcrumb-item active">Profile</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="profile-header">
<div class="row align-items-center">
<div class="col-auto profile-image">
<a href="#">
<img class="rounded-circle" alt="User Image" src="<?php echo$row1['image']; ?>">
</a>
</div>
<div class="col ms-md-n2 profile-user-info">
<h4 class="user-name mb-0 text-uppercase"><?php echo $row1['prenom']; ?> <?php echo $row1['nom']; ?></h4>
<h6 class="text-muted text-uppercase"><?php echo $row['role']; ?></h6>
<div class="user-Location"><i class="fas fa-map-marker-alt"></i> <?php echo $row1['adresse']; ?></div>
<div class="about-text">Lorem ipsum dolor sit amet.</div>
</div>
<div class="col-auto profile-btn">
<a href="" class="btn btn-primary">
Edit
</a>
</div>
</div>
</div>
<div class="profile-menu">
<ul class="nav nav-tabs nav-tabs-solid">
<li class="nav-item">
<a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
</li>

</ul>
</div>
<div class="tab-content profile-tab-cont">

<div class="tab-pane fade show active" id="per_details_tab">

<div class="row">
<div class="col-lg-9">
<div class="card">
<div class="card-body">
<h5 class="card-title d-flex justify-content-between">
<span>Personal Details</span>
<a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i class="far fa-edit me-1"></i>Edit</a>
</h5>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
<p class="col-sm-9 text-uppercase"><?php echo $row1['nom']; ?> <?php echo $row1['prenom']; ?></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
<p class="col-sm-9"><?php echo $row1['date_de_naissance']; ?></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email ID</p>
<p class="col-sm-9"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a1cbcec9cfc5cec4e1c4d9c0ccd1cdc48fc2cecc"><?php echo $row1['email']; ?></a></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
<p class="col-sm-9"><?php echo $row1['telephone']; ?></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Address</p>
 <p class="col-sm-9 mb-0"><?php echo $row1['adresse']; ?><br></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">cin</p>
 <p class="col-sm-9 mb-0"><?php echo $row1['cin']; ?><br></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0">Sex</p>
 <p class="col-sm-9 mb-0"><?php echo $row1['gender']; ?><br></p>
</div>
</div>
</div>
</div>
<div class="col-lg-3">

<div class="card">
<div class="card-body">
<h5 class="card-title d-flex justify-content-between">
<span>Account Status</span>
</h5>
<button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i> Active</button>
</div>
</div>


<div class="card">
<div class="card-body">
<h5 class="card-title d-flex justify-content-between">
<span>deplome </span>
</h5>
<div class="skill-tags">
<span><?php echo $row1['deploma']; ?></span>

</div>
</div>
</div>

</div>
</div>

</div>


</div>
</div>
</div>
</div>
</div>

</div>


<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>
<?php 
    }
  else {
    header('Location: error-404.php');
    exit;
  }
?>
