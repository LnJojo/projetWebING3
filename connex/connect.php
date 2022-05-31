<?php
	
function connect() {
	//Affectation des variables à des éléments de la base de données
	$database_name = "piscine"; //Nom de la base de données
	$database_user = "root"; //Nom de l'utilisateur de la base de données
	$database_password = ""; //Mot de passe de l'utilisateur de la base de données
	try {
	//Affectation de la variable $bdd à une requete de connexion à la base de données
		$bdd = new PDO('mysql:host=localhost;port=3306;dbname='.$database_name, $database_user, $database_password);
		return $bdd; //retourne la connexion à la base de données
	}
	//Affiche l'erreur sur la page dans le navigateur si il y'en a une
	catch (PDOException $e) {
		echo 'Problème de connexion : '.$e->getMessage();
	}
}
	
?>