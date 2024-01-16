<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';
// Check if the form is submitted

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $nom_formateur = $_POST['nom'];
    $prenom_formateur = $_POST['prenom'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $cin = $_POST['cin'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $gender=$_POST['gender'];
    $deploma = $_POST['deploma'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $filiere_id=$_POST['filiere'];
    $module_id=$_POST['module'];
    $filiere_id1=$_POST['filiere1'];
    $module_id1=$_POST['module1'];
    $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageDir = 'upload/';
    $imagePath = $imageDir . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $image = $imagePath;
    }
}
$sql = "INSERT INTO _user (username, password, role) VALUES ('$username', '$password', 'formateur')";
if (mysqli_query($conn, $sql)) {
    $user_id = mysqli_insert_id($conn);
    $sql2 = "INSERT INTO formateur (nom, prenom, email, date_de_naissance, cin, adresse, telephone, deploma, gender, image, user_id) VALUES ('$nom_formateur', '$prenom_formateur', '$email', '$date', '$cin', '$adresse', '$telephone', '$deploma', '$gender', '$image', $user_id)";
    if (mysqli_query($conn, $sql2)) {
        $formateur_id = mysqli_insert_id($conn);
        $sql3 = "";
        if (empty($filiere_id1)) {
            $sql3 = "INSERT INTO filiere_formateur (filiere_id, formateur_id) VALUES ($filiere_id, $formateur_id)";
        } else {
            $sql3 = "INSERT INTO filiere_formateur (filiere_id, formateur_id) VALUES ($filiere_id, $formateur_id), ($filiere_id1, $formateur_id)";
        }
        if (mysqli_query($conn, $sql3)) {
            $sql4 = "";
            if (empty($module_id1)) {
                $sql4 = "INSERT INTO module_formateur (module_id, formateur_id) VALUES ($module_id, $formateur_id)";
            } else {
                $sql4 = "INSERT INTO module_formateur (module_id, formateur_id) VALUES ($module_id, $formateur_id), ($module_id1, $formateur_id)";
            }
            if (mysqli_query($conn, $sql4)) {
                header('Location: formateur.php?success=ajouter');
            }
        }
    }
}

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
<h3 class="page-title">Ajouter Formateur</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur.php">Formateur</a></li>
<li class="breadcrumb-item active">Ajouter Formateur</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
<form method="POST" action="add-formateur.php" enctype="multipart/form-data">
<div class="row">
<div class="col-12">
<h5 class="form-title"><span>détails de base</span></h5>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Nom <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Entrez le nom" name="nom" required>
</div>
</div>

<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Prénom <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Entrez le prenom" name="prenom" required>
</div>
</div>

<div class="col-12 col-sm-4">
<div class="form-group local-forms calendar-icon">
<label>Date De Naissance <span class="login-danger">*</span></label>
<input class="form-control datetimepicker" type="text" placeholder="DD-MM-YYYY" name="date" required>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Mobile <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Entrez le téléphone" name="telephone" required>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Email <span class="login-danger">*</span></label>
<input type="email" class="form-control" placeholder="Entrez E-mail" name="email" required>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label> sélectionnez le sexe <span class="login-danger">*</span></label>
    <select  name="gender"  class="form-control select" required>
        <option  selected disabled>sélectionnez le sexe</option>
        <option  value="homme">homme</option>
        <option  value="femme">femme</option>
    </select>
</div>
</div>

<div class="col-12">
<h5 class="form-title"><span>détails de connexion</span></h5>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>nom d'utilisateur <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Entrez nom d'utilisateur" name="username" required>
</div>
</div>

<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>mot de passe <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Entrez mot de passe" name="password" required>
</div>
</div>

<div class="col-12">
<h5 class="form-title"><span>Adresse / Diplôme</span></h5>
</div>
<div class="col-6">
<div class="form-group local-forms">
<label>Adresse <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Enter address" name="adresse" required>
</div>
</div>

<div class="col-6">
<div class="form-group local-forms">
<label>CIN <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Enter CIN" name="cin" required>
</div>
</div>
<div class="col-6">
<div class="form-group local-forms">
<label>Diplôme <span class="login-danger">*</span></label>
<input type="text" class="form-control" placeholder="Enter Deploma" name="deploma" required>
</div>
</div>
<div class="col-12">
<h5 class="form-title"><span>Filiéres / Modules</span></h5>
</div>
<?php 
 $sql ="SELECT filiere.nom_filiere,filiere.id
 FROM filiere
 INNER JOIN centre ON centre.id = filiere.centre_id
 INNER JOIN _admin ON _admin.centre_id = centre.id
 INNER JOIN _user ON _user.id = _admin.user_id
 WHERE _user.username ='$username'";
     $result = $conn->query($sql);

     $filieres = [];
     if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
             $filieres[] = $row;
             
         }
        
     }   
?>
<div class="col-6">
<div class="form-group local-forms">
<label>sélectionnez Filière<span class="login-danger">*</span></label>

<select class="form-control select" id="filiere" name="filiere" required>
<option value="" selected disabled>sélectionnez Filière</option>
<?php foreach ($filieres as $filiere) : ?>
    <option value="<?php echo $filiere['id']?>"><?php echo $filiere['nom_filiere']?></option>
<?php endforeach; ?>
</select>
</div>
</div>

<div class="col-6">
<div class="form-group local-forms">
<label> sélectionnez Matière <span class="login-danger">*</span></label>
    <select id="result" name="module"  class="form-control select" required>
    </select>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filiere').change(function() {
                var selectedValue = $(this).val();

                // Send the selected value to the PHP script asynchronously
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: { value: selectedValue },
                    success: function(response) {
                        $('#result').html(response); // Display the response in the element with ID 'result'
                    }
                });
            });
        });
    </script>

<?php 
 $sql1 ="SELECT filiere.nom_filiere,filiere.id
 FROM filiere
 INNER JOIN centre ON centre.id = filiere.centre_id
 INNER JOIN _admin ON _admin.centre_id = centre.id
 INNER JOIN _user ON _user.id = _admin.user_id
 WHERE _user.username ='$username'";
     $result1 = $conn->query($sql1);

     $filieres1 = [];
     if ($result1->num_rows > 0) {
         while ($row1 = $result1->fetch_assoc()) {
             $filieres1[] = $row1;
             
         }
        
     }   
?>
<div class="col-6">
<div class="form-group local-forms">
<label>sélectionnez Filière<span class="login-danger">*</span></label>

<select class="form-control select" id="filiere1" name="filiere1">
<option value="" selected disabled>sélectionnez Filière</option>
<?php foreach ($filieres1 as $filiere1) : ?>
    <option value="<?php echo $filiere1['id']?>"><?php echo $filiere1['nom_filiere']?></option>
<?php endforeach; ?>
</select>
</div>
</div>

<div class="col-6">
<div class="form-group local-forms">
<label> sélectionnez Matière <span class="login-danger">*</span></label>
    <select id="result1" name="module1"  class="form-control select" >

    </select>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filiere1').change(function() {
                var selectedValue = $(this).val();

                // Send the selected value to the PHP script asynchronously
                $.ajax({
                    url: 'process1.php',
                    type: 'POST',
                    data: { value: selectedValue },
                    success: function(response) {
                        $('#result1').html(response); // Display the response in the element with ID 'result'
                    }
                });
            });
        });
    </script>
<style>
        #img{
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>

<div class="col-12 col-sm-4">
<div class="form-group students-up-files">
<label>Télécharger la photo d'etudiant (150px X 150px)</label>
<div class="uplod">
<label class="file-upload image-upbtn mb-0">
Choisir le fichier <input id="input" type="file" name="image" required>
</label>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="form-group students-up-files">
<div class="uplod">

<img id="img" src="assets/img/user.png" alt="Preview"  class="img-fluid" >

</div>
</div>
</div>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('img').src = e.target.result;
                    document.getElementById('img').style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('input').addEventListener('change', function () {
            readURL(this);
        });
</script>

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

<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>