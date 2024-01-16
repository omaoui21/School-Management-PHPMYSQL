<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $selectedLanguage = $_POST['language'];


  $_SESSION['language'] = $selectedLanguage;


  $langFile = 'lang_' . $selectedLanguage . '.php';
  include($langFile);

  header("Location: {$_SERVER['HTTP_REFERER']}");
}
?>
