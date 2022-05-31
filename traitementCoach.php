<?php

require_once("connex/connect.php");

function rdvCoach($idCoach)
{                    ///Pour afficher les rdv du coach de la session
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    if ($db_found) {
        $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=1 ORDER BY Date";
        $result = mysqli_query($db_handle, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $nom = getNomClient($row[2]);
            $prenom = getPrenomClient($row[2]);
            echo "<form method='post' action='Rendez-vous.php'>
            <tr>
            <td id='client'>" . $nom . " " . $prenom . "</td>
            <td id='date'>" . $row[3] . "</td>
            <td id='heure'>" . $row[4] . " H</td>
            <td id='adresse'>La salle de sport</td>
            <td id='infos'>" . $row[6] . "</td>
        </tr>
        </form>";
        }
    }
}

function getNomClient($idClient)                ///Recuperer le nom de son client
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
        $name = $data["Nom"];
        return $name;
    }
}

function getPrenomClient($idClient)             ///Recuperer le prenom de son client
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
        $name = $data["Prenom"];
        return $name;
    }
}

function ajoutRdv($date, $heure, $infos, $idCoach)
{         ///Pour ajouter un nouveau coach avec ses differentes informations

    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {

        $sql = "SELECT * FROM rdv WHERE Heure_Debut=$heure AND ID_Coach=$idCoach";
        $result = mysqli_query($db_handle, $sql);

        if ($result->num_rows == 0) {
            $heurefin = $heure + 2;
            $sql = "INSERT INTO rdv (ID, ID_Coach, ID_Client, Date, Heure_Debut, Heure_Fin, Infos, dispo)
            VALUES (0," . $idCoach . ",8,'" . $date . "'," . $heure . "," . $heurefin . ",'" . $infos . "',0);";
            $result = mysqli_query($db_handle, $sql);

            return true;
        } else {
            return false;
        }
    }
}
