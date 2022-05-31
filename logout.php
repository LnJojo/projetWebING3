<?php
session_start();
session_destroy();
header('Location: connexion.php');
exit;

//Cette page permet la déconnexion des utilisateurs s'ils sont connectés
//elle redirige vers l'accueil par la même occasion

?>