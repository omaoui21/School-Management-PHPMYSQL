<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Preskool - Exam</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar/navbar.php' ?>


<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row align-items-center">
<div class="col">
<h3 class="page-title">Edit Exam</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="exam.html">Exam</a></li>
<li class="breadcrumb-item active">Edit Exam</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
<form>
<div class="row">
<div class="col-12">
<h5 class="form-title"><span>Exam Information</span></h5>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Exam Name <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="Class Test">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Class <span class="login-danger">*</span></label>
<select class="form-control select">
<option>10</option>
<option>LKG</option>
<option>UKG</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
</select>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Subject <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="English">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Fees <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="$50">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Start Time <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="10:00 AM">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>End Time <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="01:00 PM">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Event Date <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="26-11-2020">
</div>
</div>
<div class="col-12">
<div class="student-submit">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

</div>


<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/select2/js/select2.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>