<?php
session_start();


// Check if user is not logged in or not a formateur
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'formateur') {
    header('Location: login.php');
    exit;
}

include 'db/db.php';

$username = $_SESSION['username'];

// Get the formateur ID based on the logged-in user
$sql = "SELECT formateur.id
        FROM formateur
        INNER JOIN _user ON _user.id = formateur.user_id
        WHERE _user.username = '$username'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$formateurId = $row['id'];

// Retrieve the module options for the form
$sql = "SELECT module.id, module.nom_module
        FROM module
        INNER JOIN module_formateur ON module_formateur.module_id = module.id
        WHERE module_formateur.formateur_id = $formateurId";

$result = mysqli_query($conn, $sql);
$moduleOptions = '';
while ($row = mysqli_fetch_assoc($result)) {
    $moduleId = $row['id'];
    $moduleName = $row['nom_module'];
    $moduleOptions .= '<option value="' . $moduleId . '">' . $moduleName . '</option>';
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $module_id = $_POST['module_id'];
    
    $targetDirectory = "upload/"; // Specify the directory where you want to store the uploaded files
    $fileName = $_FILES["file"]["name"];
    $targetFilePath = $targetDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Move the uploaded file to the target directory
    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
    // Prepare the INSERT statement
    $sql = "INSERT INTO course (nom, description,module_id, file_course) VALUES ('$nom', '$description',$module_id,'$targetFilePath')";
    

    if (mysqli_query($conn, $sql)) {
        // Redirect to a success page or perform any other desired action
        header('Location: course.php?success=ajouter');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>ShemsyMassar - Cours</title>

    <link rel="shortcut icon" href="assets/img/favicon.png">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<?php include 'navbar/navbar.php' ?>


        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Ajouter un Cours</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="course.php">Cours</a></li>
                                <li class="breadcrumb-item active">Ajouter un cour</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="add-course.php" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="form-title"><span>Informations sur le Cours</span></h5>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                            <label for="nom">Nom:</label>
                                                <input type="text" id="nom" name="nom" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                  
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                    <label for="module_id">Sélectionnez le Matière:</label>
                                                    <select name="module_id" id="module_id" class="form-control" required>
                                                        <?php echo $moduleOptions; ?>
                                                    </select>
                                                    </div>
                                            </div>
                                
                                       
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                            <label for="description">Description:</label>
                                                <textarea id="description" name="description" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                            <label for="file">File:</label>
                                                <input type="file" id="file" class="form-control" name="file" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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