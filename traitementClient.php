<?php
require_once("connex/connect.php");

//identifier votre BDD
$database = "piscine";
//identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);


//---------------------FONCTION POUR LES RDV-----------------------------//

function priseRdv($idClient, $idRDV)            ///Prise de rdv avec l'id du client et l'id du rdv
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);
    if ($db_found) {
        $sql = "UPDATE rdv SET ID_Client = '$idClient', dispo = 1 WHERE id = $idRDV";
        $result = mysqli_query($db_handle, $sql);
    }
}

function annulerRdv($idRdv){                    ///Annuler un rdv avec son id
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);
    if ($db_found) {
        $idClient = $_SESSION['id'];
        $sql = "UPDATE rdv SET dispo = 0 WHERE id =$idRdv";
        $result = mysqli_query($db_handle, $sql);
    }
}

function afficherRdv($idCoach, $date)           ///Pour pouvoir afficher les rdv avec la date selectionnee
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    if ($db_found) {
        $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
        $result = mysqli_query($db_handle, $sql);

        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='activitesSportives.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    }
}

function mesRdv($idClient)                      ///Affiche les rdv du client
{
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    if ($db_found) {
        $sql = "SELECT * FROM rdv where ID_Client =$idClient AND dispo=1 ORDER BY Date";
        $result = mysqli_query($db_handle, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $nom = getNameCoach($row[1]);
            echo "<form method='post' action='Rendez-vous.php'>
            <tr>
            <td id='nom'>" . $nom . "</td>
            <td id='date'>". $row[3]."</td>
            <td id='heure'>". $row[4] ." H</td>
            <td id='adresse'>La salle de sports</td>
            <td id='infos'>".$row[6]."</td>
            <td><button class='btn btn-primary' name='annuler' type='submit' style='background: rgb(0,0,0);'>Annuler</button>
                <input type='hidden' value='$row[0]' name='idRDV'/>
            </td>
        </tr>
        </form>";
        }
    }
}

//---------------------FONCTION POUR LES COACHS A AFFICHER-----------------------------//

function mesCoachs($specialite, $date)              ///Pour avoir les coachs de la specialite
{
        //identifier votre BDD
        $database = "piscine";
        //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
        $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, $database);


        if ($db_found) {
            $sql = "SELECT * FROM coach WHERE specialite='$specialite' ORDER BY ID";        ///On selectionne les coach avec la specialite selectionnee
            $result = mysqli_query($db_handle, $sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_row($result)) {
                    echo "<form method='post' action='autreCoachs.php'>
            <tr>
                <td id='idCoach'>" . $row[0] . "</td>
                <td id='coach'>" . $row[1]." " .$row[2] . "</td>
                <td id='specialite'>" . $row[5] . "</td>
                <td id='Photo'><img></td>
                <td id='CV'></td>
                <td>";
                $sql2 = "SELECT DISTINCT t1.ID 
                FROM rdv t1	
                LEFT JOIN coach t2 ON t2.ID = t1.ID_Coach
                WHERE t2.ID=$row[0] AND t1.dispo=0 AND t1.date='$date'";                ///On selectionne les rdv du coach actuelle dans la boucle pour afficher
                $result2 = mysqli_query($db_handle, $sql2);                             ///les rdv selon la date selectionnee
                if ($result->num_rows > 0){
                    while ($row2 = mysqli_fetch_row($result2)){
                        $heure = getHeureRDV($row2[0]);
                        echo "<button class='btn btn-success' style='margin-left: 5px;' type='submit' name='prendreRDV'>$heure h</button>
                        <input type='hidden' value='$row2[0]' name='idRdv'/>";
                    }
                }

                
                echo "</td>
            </tr>
            </form>";
                }
            }
        }
        else{
            echo "Aucun coachs";
        }
}

function checkSearch($search){                                                          ///Pour verifier si une recherche de specialite est valide
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    if ($db_found) {
        $sql = "SELECT * FROM coach WHERE specialite='$search' ORDER BY ID";
        $result = mysqli_query($db_handle, $sql);

        if ($result->num_rows > 0) {
            return true;
        }
        else{
            return false;
        }
    }
}

function checkSearchNomPrenom($search){                                                          ///Pour verifier si une recherche de specialite est valide
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    if ($db_found) {
        $sql = "SELECT * FROM coach WHERE nom='$search' OR prenom='$search' ORDER BY ID";
        $result = mysqli_query($db_handle, $sql);

        if ($result->num_rows > 0) {
            return true;
        }
        else{
            return false;
        }
    }
}

function searchCoachsByName($specialite)                                                      ///Pour chercher les coachs de la specialite avec la recherche
{
        //identifier votre BDD
        $database = "piscine";
        //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
        $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, $database);


        if ($db_found) {
            $sql = "SELECT * FROM coach WHERE nom='$specialite' OR prenom='$specialite' ORDER BY ID";
            $result = mysqli_query($db_handle, $sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>
                <td id='idCoach'>" . $row[0] . "</td>
                <td id='coach'>" . $row[1]." " .$row[2] . "</td>
                <td id='specialite'>" . $row[5] . "</td>
                <td id='Photo'><img></td>
                <td id='CV'></td>
            </tr>";
                }
            }
            else{
                echo "<tr>Aucun coach correspondant à la recherche</tr>";
            }
        }

}

function searchCoachsByType($specialite)                                                      ///Pour chercher les coachs de la specialite avec la recherche
{
        //identifier votre BDD
        $database = "piscine";
        //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
        $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, $database);


        if ($db_found) {
            $sql = "SELECT * FROM coach WHERE specialite='$specialite' ORDER BY ID";
            $result = mysqli_query($db_handle, $sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>
                <td id='idCoach'>" . $row[0] . "</td>
                <td id='coach'>" . $row[1]." " .$row[2] . "</td>
                <td id='specialite'>" . $row[5] . "</td>
                <td id='Photo'><img></td>
                <td id='CV'></td>
            </tr>";
                }
            }
            else{
                echo "<tr>Aucun coach correspondant à la recherche</tr>";
            }
        }

}

function getHeureRDV($idRdv){                                                           ///Pour recuperer l'heure du rdv
    //identifier votre BDD
    $database = "piscine";
    //identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        $sql = "SELECT Heure_debut FROM rdv WHERE id=$idRdv";
        $result = mysqli_query($db_handle, $sql);

        $data = mysqli_fetch_assoc($result);
        $heure = $data['Heure_debut'];

        return $heure;

    }
}





function getNameCoach($idCoach)
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

//-----------------------------------AFFICHAGE DES RDV DISPOS SELON LE MODAL DE LA PAGE---------------------------------------//

if (isset($_POST["dateRdv1"]) && !empty($_POST["dateRdv1"])) {      ///RDV disponibles du coach1

    $idCoach = 1;
    $date = $_POST["dateRdv1"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='activitesSportives.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}


if (isset($_POST["dateRdv2"]) && !empty($_POST["dateRdv2"])) {      ///RDV disponibles du coach2

    $idCoach = 2;
    $date = $_POST["dateRdv2"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='activitesSportives.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv3"]) && !empty($_POST["dateRdv3"])) {      ///RDV disponibles du coach3

    $idCoach = 3;
    $date = $_POST["dateRdv3"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='activitesSportives.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv4"]) && !empty($_POST["dateRdv4"])) {      ///RDV disponibles du coach4

    $idCoach = 4;
    $date = $_POST["dateRdv4"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='activitesSportives.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv5"]) && !empty($_POST["dateRdv5"])) {          ///RDV disponibles du coach5

    $idCoach = 5;
    $date = $_POST["dateRdv5"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='activitesSportives.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

//////////////////PAGE SPORTS DE COMPETITION

if (isset($_POST["dateRdv6"]) && !empty($_POST["dateRdv6"])) {          ///RDV disponibles du coach6

    $idCoach = 6;
    $date = $_POST["dateRdv6"];

    $sql = "SELECT * FROM rdv where ID_Coach ='$idCoach' AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='SportsCompetition.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv7"]) && !empty($_POST["dateRdv7"])) {          ///RDV disponibles du coach7

    $idCoach = 7;
    $date = $_POST["dateRdv7"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='SportsCompetition.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv8"]) && !empty($_POST["dateRdv8"])) {          ///RDV disponibles du coach8

    $idCoach = 8;
    $date = $_POST["dateRdv8"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='SportsCompetition.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv9"]) && !empty($_POST["dateRdv9"])) {          ///RDV disponibles du coach9

    $idCoach = 9;
    $date = $_POST["dateRdv9"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='SportsCompetition.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv10"]) && !empty($_POST["dateRdv10"])) {          ///RDV disponibles du coach10

    $idCoach = 10;
    $date = $_POST["dateRdv10"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='SportsCompetition.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}

if (isset($_POST["dateRdv11"]) && !empty($_POST["dateRdv11"])) {          ///RDV disponibles du coach11

    $idCoach = 11;
    $date = $_POST["dateRdv11"];

    $sql = "SELECT * FROM rdv where ID_Coach =$idCoach AND dispo=0 AND date='$date' ORDER BY Heure_Debut";
    $result = mysqli_query($db_handle, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<form method='post' action='SportsCompetition.php'>
            <tr>
            <td><h3>" . $row[4] . " H</h3></td>
            <td><input type='submit' value='Prendre' name='prendreRDV'>
                <input type='hidden' value='$row[0]' name='idRDV'/>
                <input type='hidden' value='$row[4]' name='heure'/>
                <input type='hidden' value='$row[3]' name='date'/>
            </td>
            </tr>
            </form>";
        }
    } else {
        echo "<tr>Aucun rendez-vous disponible</tr>";
    }
}




