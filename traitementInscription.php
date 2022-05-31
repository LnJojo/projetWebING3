<?php
require_once("connex/connect.php");


//$nom,$prenom,$adresse,$ville,$codePostal,$pays,$telephone,$carteEtudiant,$typeCarte,$numCarte,$nomCarte,$dateExpiration,$cvv,$email,$pw
function creationCompte()                       ///Fonction pour creer un compte
{

    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];
    $adresse = $_SESSION["adresse"];
    $ville = $_SESSION["ville"];
    $codePostal = $_SESSION["codePostal"];
    $pays = $_SESSION["pays"];
    $telephone = $_SESSION["telephone"];
    $carteEtudiant = $_SESSION["carteEtudiant"];
    $typeCarte = $_SESSION["typeCarte"];
    $numCarte = $_SESSION["numCarte"];
    $nomCarte = $_SESSION["nomCarte"];
    $dateExpiration = $_SESSION["dateExpiration"];
    $cvv = $_SESSION["cvv"];
    $email = $_SESSION["email"];
    $pw = $_SESSION["password"];

    try {
        $check = connect()->prepare("SELECT * FROM client WHERE Email = ?");            ///On prepare la requete sql pour savoir si un email est deja utilise
        $check->execute(array($email));
        $result = $check->fetch(PDO::FETCH_OBJ);
        if ($result == false) { //S'il n'existe pas déjà
            $req = connect()->prepare("INSERT INTO client (ID, Nom, Prenom, Adresse, Ville, Code_Postale, Pays, Telephone, Carte_Etudiant, Type_Carte, Numero_carte, Nom_Carte, Date_Expiration, CVV, Email, `password`)
                 VALUES (0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $req->execute(array($nom, $prenom, $adresse, $ville, $codePostal, $pays, $telephone, $carteEtudiant, $typeCarte, $numCarte, $nomCarte, $dateExpiration, $cvv, $email, $pw));
            $req->closeCursor();
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Le compte n'a pas été créé : " . $e->getMessage();
    }


    /*if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO client (ID, Nom, Prenom, Adresse, Ville, Code_Postale, Pays, Telephone, Carte_Etudiant, Type_Carte, Numero_carte, Nom_Carte, Date_Expiration, CVV, Email, `password`)
        VALUES
        (0," . "'" . $nom . "'" . "," . "'" . $prenom . "'" . "," . "'" . $adresse . "'" . "," . "'" . $ville . "'" . "," . $codePostal . "," . "'" . $pays . "'" . "," . "'" . $telephone . "'" . "," . $carteEtudiant . "," . "'" . $typeCarte . "'" . "," . "'" . $numCarte . "'" . "," . "'" . $nomCarte . "'" . "," . "'" . $dateExpiration . "'" . "," . $cvv . "," . "'" . $email . "'" . "," . "'" . $pw . "'" . ")";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: Accueil.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();*/
}

function logIn()                ///Fonction pour se connecter a un compte coach ou client 
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    $password = $_SESSION["password"];
    $email = $_SESSION["email"];

    if ($_SESSION["type"] == "client") {            ///Si l'utilisateur a selectionne sur client lors de la connexion
        $sql = "SELECT id, nom, prenom, adresse, ville, Email, password FROM " . $_SESSION["type"] . " WHERE Email = '$email' AND  password = '$password'";
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        if ($db_found) {
            if (!empty($data)) {
                $_SESSION["id"] = $data["id"];
                $_SESSION["nom"] = $data["nom"];
                $_SESSION["prenom"] = $data["prenom"];
                $_SESSION["adresse"] = $data["adresse"];
                $_SESSION["ville"] = $data["ville"];
                $_SESSION["email"] = $data["Email"];
                $_SESSION["password"] = $data["password"];

                return $_SESSION;                   ///On recupere la session
            } else {
                return false;                       ///Si le mot de passe ou email n'est pas valide on retourne false
            }
        }
    }
    if ($_SESSION["type"] == "coach") {             ///De meme pour la partie coach
        $sql = "SELECT id, nom, prenom, Email, password FROM " . $_SESSION["type"] . " WHERE Email = '$email' AND  password = '$password'";
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        if ($db_found) {
            if (!empty($data)) {
                $_SESSION["id"] = $data["id"];
                $_SESSION["nom"] = $data["nom"];
                $_SESSION["prenom"] = $data["prenom"];
                $_SESSION["email"] = $data["Email"];
                $_SESSION["password"] = $data["password"];

                return $_SESSION;
            } else {
                return false;
            }
        }
    }

}

function creationCompteAdmin()                       ///Fonction pour creer un compte
{

    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];
    $email = $_SESSION["email"];
    $pw = $_SESSION["password"];

    try {
        $check = connect()->prepare("SELECT * FROM administrateur WHERE Email = ?");            ///On prepare la requete sql pour savoir si un email est deja utilise
        $check->execute(array($email));
        $result = $check->fetch(PDO::FETCH_OBJ);
        if ($result == false) { //S'il n'existe pas déjà
            $req = connect()->prepare("INSERT INTO administrateur (ID, Nom, Prenom, Email, `password`)
                 VALUES (0, ?, ?, ?, ?)");
            $req->execute(array($nom, $prenom, $email, $pw));
            $req->closeCursor();
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Le compte n'a pas été créé : " . $e->getMessage();
    }


}
