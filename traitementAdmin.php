<?php

require_once("connex/connect.php");


function logIn()                ///Connexion admin 
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    $password = $_SESSION["password"];
    $email = $_SESSION["email"];

    $sql = "SELECT ID, Nom, Prenom, Email, Password FROM administrateur WHERE Email = '$email' AND  Password = '$password'";
    $result = mysqli_query($db_handle, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($db_found) {
        //echo $sql;
        if (!empty($data)) {
            $_SESSION["id"] = $data["ID"];
            $_SESSION["nom"] = $data["Nom"];
            $_SESSION["prenom"] = $data["Prenom"];
            $_SESSION["adresse"] = "";
            $_SESSION["ville"] = "";
            $_SESSION["email"] = $data["Email"];
            $_SESSION["password"] = $data["Password"];
            //echo "Changement des variables session ";

            return $_SESSION;
        } else {
            return false;
        }
    }
}

function mesCoachs()                        ///Fonction pour afficher les differents coachs avec les informations
{
        //identifier votre BDD
        $database = "piscine";
        //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
        $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, $database);


        if ($db_found) {
            $sql = "SELECT * FROM coach ORDER BY ID";
            $result = mysqli_query($db_handle, $sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_row($result)) {
                    echo "<form method='post' action='coachs.php'>
            <tr>
                <td id='idCoach'>" . $row[0] . "</td>
                <td id='coach'>" . $row[1]." " .$row[2] . "</td>
                <td id='specialite'>" . $row[5] . "</td>
                <td id='Photo'><img></td>
                <td id='CV'></td>
                <td><button class='btn btn-danger' style='margin-left: 5px;' type='submit' name='supprimer'><i class='fa fa-trash' style='font-size: 15px;'></i></button>
                    <input type='hidden' value='$row[0]' name='idCoach'/>
                </td>
            </tr>
            </form>";
                }
            }
        }
        else{
            echo "Aucun coachs";
        }
}


function getNameCoach($idCoach)             ///Pour recuperer le nom du coach avec son id
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        $sql = "SELECT DISTINCT t1.Nom	
                FROM coach t1	
                LEFT JOIN rdv t2 ON t2.ID_Coach = t1.ID
                WHERE t2.ID_Coach='$idCoach'";
        $result = mysqli_query($db_handle, $sql);

        $data = mysqli_fetch_assoc($result);
        $name = $data['Nom'];

        return $name;
    }
}

function getSpecialite($idCoach){           ///Pour recuperer la specialite du coach avec son id
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        $sql = "SELECT DISTINCT t1.Nom	
                FROM coach t1	
                LEFT JOIN rdv t2 ON t2.ID_Coach = t1.ID
                WHERE t2.ID_Coach='$idCoach'";
        $result = mysqli_query($db_handle, $sql);

        $data = mysqli_fetch_assoc($result);
        $name = $data['Nom'];

        return $name;
    }
}

function ajoutCoach($nom, $prenom,$email, $password,  $specialite){         ///Pour ajouter un nouveau coach avec ses differentes informations

    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {

        $sql = "SELECT * FROM coach WHERE Email = $email";
        $result = mysqli_query($db_handle, $sql);

        
        if(!$result){
            $sql = "INSERT INTO coach (ID, nom, prenom, email, password, specialite)
            VALUES (0,'". $nom."','".$prenom."','".$email."','".$password."','".$specialite."')";
            $result = mysqli_query($db_handle, $sql);

            //INSERT INTO coach (ID, nom, prenom, email, password, specialite)VALUES(0,"nom","prenom","email@email.fr","password","specialite")
            return true;
        }
        else{
            return false;
        }
        
        
    }
    

}

function supprimerCoach($idCoach){                  ///Pour supprimer le coach avec son id
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);
    if ($db_found) {
        $idClient = $_SESSION['id'];
        $sql = "DELETE FROM coach WHERE ID='$idCoach'";
        $result = mysqli_query($db_handle, $sql);
    }
}


function getNameClient($idClient)             ///Pour recuperer le nom du client avec son id
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        $sql = "SELECT DISTINCT t1.Nom	
                FROM client t1	
                LEFT JOIN rdv t2 ON t2.ID_Client = t1.ID
                WHERE t2.ID_Client='$idClient'";
        $result = mysqli_query($db_handle, $sql);

        $data = mysqli_fetch_assoc($result);
        $name = $data['Nom'];

        return $name;
    }
}

function getPrenomClient($idClient)             ///Pour recuperer le prenom du client avec son id
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        $sql = "SELECT DISTINCT t1.Prenom	
                FROM client t1	
                LEFT JOIN rdv t2 ON t2.ID_Client = t1.ID
                WHERE t2.ID_Client='$idClient'";
        $result = mysqli_query($db_handle, $sql);

        $data = mysqli_fetch_assoc($result);
        $name = $data['Prenom'];

        return $name;
    }
}

function afficherRdv(){                             ///Affiche les differents rdv pris par les clients
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    if ($db_found) {
        $sql = "SELECT * FROM rdv where dispo=1 ORDER BY Date";
        $result = mysqli_query($db_handle, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $nomCoach = getNameCoach($row[1]);
            $nomClient = getNameClient($row[2]);
            $prenomClient = getPrenomClient($row[2]);
            echo "<form method='post' action='Rendez-vous.php'>
            <tr>
            <td id='nomCoach'>" . $nomCoach . "</td>
            <td id='nomClient'>" . $nomClient . " " .$prenomClient . "</td>
            <td id='date'>". $row[3]."</td>
            <td id='heure'>". $row[4] ." H</td>
            <td id='adresse'>La salle de sports</td>
            <td id='infos'>".$row[6]."</td>
        </tr>
        </form>";
        }
    }
}
