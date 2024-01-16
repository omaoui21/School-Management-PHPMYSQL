<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Preskool - Teachers</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

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
<h3 class="page-title">Edit Teachers</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="teachers.html">Teachers</a></li>
<li class="breadcrumb-item active">Edit Teachers</li>
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
<h5 class="form-title"><span>Basic Details</span></h5>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Teacher ID <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="PRE1234">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Name <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="Vincent">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Gender <span class="login-danger">*</span></label>
<select class="form-control select">
<option>Male</option>
<option>Female</option>
<option>Others</option>
</select>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms calendar-icon">
<label>Date Of Birth <span class="login-danger">*</span></label>
<input class="form-control datetimepicker" type="text" placeholder="29-04-2023">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Mobile <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="077 3499 9959">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms calendar-icon">
<label>Joining Date <span class="login-danger">*</span></label>
<input class="form-control datetimepicker" type="text" placeholder="29-04-2023">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Qualification <span class="login-danger">*</span></label>
<input class="form-control" type="text" value="Bachelor of Engineering">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Experience <span class="login-danger">*</span></label>
<input class="form-control" type="text" value="5">
</div>
</div>
<div class="col-12">
<h5 class="form-title"><span>Login Details</span></h5>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Username <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="Vincent">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Email ID <span class="login-danger">*</span></label>
<input type="email" class="form-control" value="vincent20@gmail.com">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Password <span class="login-danger">*</span></label>
<input type="password" class="form-control" value="vincent">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Repeat Password <span class="login-danger">*</span></label>
<input type="password" class="form-control" value="vincent">
</div>
</div>
<div class="col-12">
<h5 class="form-title"><span>Address</span></h5>
</div>
<div class="col-12 ">
<div class="form-group local-forms">
<label>Address <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="3979 Ashwood Drive">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>City <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="Omaha">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>State <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="Omaha">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Zip Code <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="3979">
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Country <span class="login-danger">*</span></label>
<input type="text" class="form-control" value="USA">
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

<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<script src="assets/plugins/select2/js/select2.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>