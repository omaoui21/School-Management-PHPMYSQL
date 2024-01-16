<?php 
include 'db/db.php';
if ($_SESSION['role'] == 'pdg') {
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query
    $query = ("SELECT * FROM _user WHERE username = '$username'");
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        $id = $row['id'];
        if ($role == 'pdg') {
            $query1 = ("SELECT * FROM pdg inner join _user on pdg.user_id='$id'");
        } 
        $result1 = mysqli_query($conn, $query1);
        $row1 = mysqli_fetch_assoc($result1);
      }
    ?>
     <div class="main-wrapper">

<div class="header">

    <div class="header-left">
        <a href="pdg-dashboard.php" class="logo">
            <img src="assets/img/logo.png" alt="Logo">
        </a>
        <a href="pdg-dashboard.php" class="logo logo-small">
            <img src="assets/img/logo-small.png" alt="Logo" width="60" height="60">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <div class="top-nav-search">
    <div id="clock"></div>
        
    </div>
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

  

    <ul class="nav user-menu">

        
        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="assets/img/icons/header-icon-04.svg" alt="">
            </a>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="<?php echo$row1['image']; ?>" width="31"
                        alt="Jassa Rich">
                    <div class="user-text">
                        <h6><?php echo $_SESSION['username'];?></h6>
                        <p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="<?php echo$row1['image']; ?>" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6><?php echo $_SESSION['username'];?></h6>
                        <p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
                    </div>
                </div>
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>

    </ul>

</div>

    <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            <span>Main Menu</span>
                        </li>
                        <li class="submenu active">
                            <a href="#"><i class="feather-grid"></i> <span> Tableau de bord</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="pdg-dashboard.php" class="active">Tableau de bord</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="liste-etudiant-par-center.php"><i class="fas fa-graduation-cap"></i> <span>Liste des Etudiants</span></a>
                        </li>
                        <li>
                            <a href="liste-formateur-par-center.php"><i class="fas fa-chalkboard-teacher"></i> <span>Liste des Formateurs</span></a>
                        </li>
                        
                        
                        <li class="submenu">
                            <a href="#"><i class="fas fa-home"></i> <span> Centre</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="centre.php">Liste Centres </a></li>
                                <li><a href="add-centre.php">Ajouter Centre</a></li>
                            </ul>
                        </li>
                      
                        <li class="submenu">
                            <a href="#"><i class="fas fa-user"></i> <span> Admin </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="admin.php">Liste Admin </a></li>
                                <li><a href="add-admin.php">Ajouter Admin</a></li>
                            </ul>
                        </li>
                       
                                            
                       
                       
                       

                    </ul>
                </div>
            </div>
        </div>
   <?php 
}
else if ($_SESSION['role'] == 'admin') {
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
        } 
        $result1 = mysqli_query($conn, $query1);
        $row1 = mysqli_fetch_assoc($result1);
      }
    ?>
     <div class="main-wrapper">

<div class="header">

    <div class="header-left">
        <a href="index.php" class="logo">
            <img src="assets/img/logo.png" alt="Logo">
        </a>
        <a href="index.php" class="logo logo-small">
            <img src="assets/img/logo-small.png" alt="Logo" width="60" height="60">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <div class="top-nav-search">
    <div id="clock"></div>
    </div>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

  

    <ul class="nav user-menu">
    <li class="nav-item dropdown noti-dropdown language-drop me-2">
    <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
    <?php if ($_SESSION['language'] === 'en') { echo '<i class="flag flag-ma"></i>'; } ?>
        <?php if ($_SESSION['language'] === 'fr') { echo '<i class="flag flag-bl"></i>'; } ?>
</a>
<div class="dropdown-menu">
  <a class="dropdown-item" href="#" onclick="submitLanguage('en')"><i class="flag flag-ma me-2"></i>العربية</a>
  <a class="dropdown-item" href="#" onclick="submitLanguage('fr')"><i class="flag flag-bl me-2"></i>Français</a>

</div>
      


<script>
      function submitLanguage(language) {
    const form = document.createElement('form');
    form.action = 'update-language.php';
    form.method = 'POST';

    const languageInput = document.createElement('input');
    languageInput.type = 'hidden';
    languageInput.name = 'language';
    languageInput.value = language;

    form.appendChild(languageInput);
    document.body.appendChild(form);
    form.submit();
  }


</script>


             
        </li>

        
        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="assets/img/icons/header-icon-04.svg" alt="">
            </a>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="<?php echo$row1['image']; ?>" width="31"
                        alt="Jassa Rich">
                    <div class="user-text">
                        <h6><?php echo $_SESSION['username'];?></h6>
                        <p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="<?php echo$row1['image']; ?>" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6><?php echo $_SESSION['username'];?></h6>
                        <p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
                    </div>
                </div>
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>

    </ul>

</div>

    <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            <span>Main Menu</span>
                        </li>
                        <li class="submenu active">
                            <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="index.php" class="active">Admin Dashboard</a></li>

                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fas fa-graduation-cap"></i> <span> Etudiants</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="etudiant.php">liste Etudiant</a></li>
                                <li><a href="add-etudiant.php">Ajouter Etudiant</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span> Formateurs</span> <span
                                class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="formateur.php">Liste formateur</a></li>
                                <li><a href="add-formateur.php">Ajouter formateur</a></li>
                            </ul>
                        </li>
                        
                        <li class="submenu">
                            <a href="#"><i class="fas fa-book-reader"></i> <span> Filières</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="filiere.php">Liste Filière </a></li>
                                <li><a href="add-filiere.php">Ajouter Filière</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fas fa-book"></i> <span> Matières</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="matiere.php">liste Matière</a></li>
                                <li><a href="add-matiere.php">Ajouter Matière</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="etudiant-archive.php"><i class="fas fa-archive"></i> <span>Archive etudiants</span></a>
                        </li>
                                             
                        <li>
                            <a href="exam.php"><i class="fas fa-file"></i> <span>Liste des examens</span></a>
                        </li>
                       
                        <li>
                            <a href="course.php"><i class="fas fa-clipboard-list"></i> <span>Liste des cours</span></a>
                        </li>
                        <li>
                            <a href="note.php"><i class="fas fa-clipboard-list"></i> <span>Liste des notes</span></a>
                        </li>
                        <li>
                            <a href="absence.php"><i class="fas fa-clipboard-list"></i> <span>Liste des absence</span></a>
                        </li>
                        <li>
                            <a href="convention.php"><i class="fas fa-file-invoice-dollar"></i> <span>Convention</span></a>
                        </li>
                        <li>
                            <a href="add-convention.php"><i class="fas fa-file-invoice-dollar"></i> <span>Creation Convention</span></a>
                        </li>
                        <li>
                            <a href="execution-programme.php"><i class="fas fa-book"></i> <span> l'execution programme</span> </a>
                        </li>
                            <!-- <ul>
                                <li><a href="add-apprentis.php">Liste des apprentis</a></li>
                          
                                <li><a href="add-entreprise.php">Liste des entreprises</a></li>

                                <li><a href="add-frais-formation.php">Liste Frais Formation</a></li>

                                <li><a href="add-frais-formation-suivi.php">Liste Frais Formation Suivi</a></li>

                                <li><a href="add-frais-vacation.php">Liste Frais Vacation</a></li>

                                <li><a href="add-acquisituin-materiel-didactique.php">Liste Acquisition materiel didactique</a></li>

                                <li><a href="add-acquisituin-materiel-informatique.php">Liste Acquisition materiel informatique</a></li>

                                <li><a href="add-acquisituin-materiel-bureau.php">Liste Acquisition materiel bureau</a></li>

                                <li><a href="add-achat-fournitures-bureau.php">Liste achat fournitures bureau</a></li>
                            </ul> -->
                      
                       

                    </ul>
                </div>
            </div>
        </div>
   <?php 
}
elseif ($_SESSION['role'] == 'formateur') {
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query
    $query = ("SELECT * FROM _user WHERE username = '$username'");
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        $id = $row['id'];
        if ($role == 'formateur') {
            $query1 = ("SELECT * FROM formateur inner join _user on formateur.user_id='$id'");
        } 
        $result1 = mysqli_query($conn, $query1);
        $row1 = mysqli_fetch_assoc($result1);
      }
    ?>
<div class="main-wrapper">

<div class="header">

<div class="header-left">
<a href="formateur-dashboard.php" class="logo">
<img src="assets/img/logo.png" alt="Logo">
</a>
<a href="formateur-dashboard.php" class="logo logo-small">
<img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
</a>
</div>

<div class="menu-toggle">
<a href="javascript:void(0);" id="toggle_btn">
<i class="fas fa-bars"></i>
</a>
</div>

<div class="top-nav-search">
<div id="clock"></div>
</div>


<a class="mobile_btn" id="mobile_btn">
<i class="fas fa-bars"></i>
</a>


<ul class="nav user-menu">





<li class="nav-item zoom-screen me-2">
<a href="#" class="nav-link header-nav-list">
<img src="assets/img/icons/header-icon-04.svg" alt="">
</a>
</li>

<li class="nav-item dropdown has-arrow new-user-menus">
<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
<span class="user-img">
<img class="rounded-circle" src="<?php echo$row1['image']; ?>" width="31" alt="Jassa Rich">
<div class="user-text">
<h6><?php echo $_SESSION['username'];?></h6>
<p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
</div>
</span>
</a>
<div class="dropdown-menu">
<div class="user-header">
<div class="avatar avatar-sm">
<img src="<?php echo$row1['image']; ?>" alt="User Image" class="avatar-img rounded-circle">
</div>
<div class="user-text">
<h6><?php echo $_SESSION['username'];?></h6>
<p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
</div>
</div>
<a class="dropdown-item" href="profile.php">My Profile</a>
<a class="dropdown-item" href="logout.php">Logout</a>
</div>
</li>

</ul>

</div>
<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="menu-title">
<span>Main Menu</span>
</li>
<li class="submenu active">
<a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="formateur-dashboard.php" class="active">Formateur Dashboard</a></li>

</ul>
</li>

<li>
<a href="etudiant-formateur.php"><i class="fas fa-users"></i> <span>Listes Etudiant</span></a>
</li>
<li>
<li class="submenu">
 <a href="#"><i class="fas fa-tasks"></i> <span> Module</span> <span
    class="menu-arrow"></span></a>
 <ul>
  <li><a href="add-mudole.php">Add module</a></li>
  <li><a href="module.php">module</a></li>
</ul>
  </li>
<li class="submenu">
 <a href="#"><i class="fas fa-tasks"></i> <span> attendance</span> <span
    class="menu-arrow"></span></a>
 <ul>
  <li><a href="attendance.php">attendance</a></li>
 <li><a href="add-attendance.php">Ajouter Absences</a></li>
</ul>
  </li>
<li class="submenu">
 <a href="#"><i class="fas fa-tasks"></i> <span> Absences</span> <span
    class="menu-arrow"></span></a>
 <ul>
  <li><a href="absence.php">liste Absences</a></li>
 <li><a href="add-absence-etudiant.php">Ajouter Absences</a></li>
</ul>
  </li>

  <li class="submenu">
 <a href="#"><i class="fas fa-clipboard"></i> <span> Notes</span> <span
    class="menu-arrow"></span></a>
 <ul>
  <li><a href="note.php">liste Notes</a></li>
 <li><a href="add-note-etudiant.php">Ajouter Note</a></li>
</ul>
  </li>

  <li  class="submenu">
 <a href="#"><i class="fas fa-clipboard-list"></i> <span> Exams</span> <span
    class="menu-arrow"></span></a>
 <ul>
  <li><a  href="exam.php">liste Exams</a></li>
 <li><a  href="add-exam.php">Ajouter Exam</a></li>
</ul>
  </li>

  <li  class="submenu">
 <a href="#"><i class="fas fa-clipboard-list"></i> <span> Cours</span> <span
    class="menu-arrow"></span></a>
 <ul>
  <li><a  href="course.php">Listes Cours</a></li>
 <li><a  href="add-course.php">Ajouter cour</a></li>
</ul>
  </li>

<li>
<a href="event.php"><i class="fas fa-calendar-day"></i> <span>Events</span></a>
</li>



<li class="menu-title">
<span>Others</span>
</li>

</li>
</ul>
</div>
</div>
</div>
    <?php 
}elseif ($_SESSION['role'] == 'etudiant') {
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query
    $query = ("SELECT * FROM _user WHERE username = '$username'");
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        $id = $row['id'];
        if ($role == 'etudiant') {
            $query1 = ("SELECT * FROM etudiant inner join _user on etudiant.user_id='$id'");
        } 
        $result1 = mysqli_query($conn, $query1);
        $row1 = mysqli_fetch_assoc($result1);
      }
    ?>
<div class="main-wrapper">

<div class="header">

<div class="header-left">
<a href="etudiant-dashboard.php" class="logo">
<img src="assets/img/logo.png" alt="Logo">
</a>
<a href="etudiant-dashboard.php" class="logo logo-small">
<img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
</a>
</div>

<div class="menu-toggle">
<a href="javascript:void(0);" id="toggle_btn">
<i class="fas fa-bars"></i>
</a>
</div>

<div class="top-nav-search">
<div id="clock"></div>
</div>


<a class="mobile_btn" id="mobile_btn">
<i class="fas fa-bars"></i>
</a>


<ul class="nav user-menu">





<li class="nav-item zoom-screen me-2">
<a href="#" class="nav-link header-nav-list">
<img src="assets/img/icons/header-icon-04.svg" alt="">
</a>
</li>

<li class="nav-item dropdown has-arrow new-user-menus">
<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
<span class="user-img">
<img class="rounded-circle" src="<?php echo$row1['image']; ?>" width="31" alt="Jassa Rich">
<div class="user-text">
<h6><?php echo $_SESSION['username'];?></h6>
<p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
</div>
</span>
</a>
<div class="dropdown-menu">
<div class="user-header">
<div class="avatar avatar-sm">
<img src="<?php echo$row1['image']; ?>" alt="User Image" class="avatar-img rounded-circle">
</div>
<div class="user-text">
<h6><?php echo $_SESSION['username'];?></h6>
<p class="text-muted mb-0"><?php echo $_SESSION['role'];?></p>
</div>
</div>
<a class="dropdown-item" href="profile.php">My Profile</a>
<a class="dropdown-item" href="logout.php">Logout</a>
</div>
</li>

</ul>

</div>
<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="menu-title">
<span>Main Menu</span>
</li>
<li class="submenu active">
<a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="etudiant-dashboard.php" class="active">Etudiant Dashboard</a></li>

</ul>
</li>


<li>
 <a href="exam.php"><i class="fas fa-clipboard-list"></i> <span>Liste des examens</span></a>
 </li>
                       
 <li>
<a href="course.php"><i class="fas fa-clipboard-list"></i> <span>Liste des cours</span></a>
</li>
<li>
<a href="absence.php" ><i class="fas fa-tasks"></i> <span>liste Absences</span></a>
</li>
<li>
<a href="note.php" ><i class="fas fa-tasks"></i> <span>liste Note</span></a>
</li>
<li>
<a href="event.php"><i class="fas fa-calendar-day"></i> <span>Events</span></a>
</li>
<li>
<a href="holiday.php"><i class="fas fa-holly-berry"></i> <span>Holiday</span></a>
</li>

<li class="menu-title">
<span>Others</span>
</li>

</li>
</ul>
</div>
</div>
</div>
    <?php 
}
    ?>
    <style>
  @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap');
</style>
    <style>
        #clock {
	font-size: 27px;
	width: 900px;
	margin: 10px;
	text-align: center;
    font-family: Orbitron;
}

    </style>
    <script>
setInterval(showTime, 1000);

function showTime() {
  let time = new Date();
  let hour = time.getHours();
  let min = time.getMinutes();
  let sec = time.getSeconds();

  let am_pm = hour >= 12 ? "PM" : "AM";

  hour = hour < 10 ? "0" + hour : hour;
  min = min < 10 ? "0" + min : min;
  sec = sec < 10 ? "0" + sec : sec;

  let currentTime = hour + ":" + min + ":" + sec + " " + am_pm;

  document.getElementById("clock").innerHTML = currentTime;
}

showTime();




    </script>
    

