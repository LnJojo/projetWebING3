<?php
session_start();
require_once("traitementInscription.php");
// Set session variables (variables globales)
$_SESSION["id"] = "";
$_SESSION["nom"] = "";
$_SESSION["prenom"] = "";
$_SESSION["adresse"] = "";
$_SESSION["ville"] = "";
$_SESSION["codePostal"] = "";
$_SESSION["pays"] = "";
$_SESSION["telephone"] = "";
$_SESSION["carteEtudiant"] = "";
$_SESSION["typeCarte"] = "";
$_SESSION["numCarte"] = "";
$_SESSION["nomCarte"] = "";
$_SESSION["dateExpiration"] = "";
$_SESSION["cvv"] = "";
$_SESSION["email"] = "";
$_SESSION["password"] = "";
$_SESSION["emailLogin"] = "";
$_SESSION["passwordLogin"] = "";
$_SESSION["idCoach"] = "";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inscription Omnes Sports</title>
    <meta charset="utf_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Account-setting-or-edit-profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search-1.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search.css">
</head>

<?php

$nom = isset($_POST["nom"]) ? $_POST["nom"] : "";
$prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : "";
$adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : "";
$ville = isset($_POST["ville"]) ? $_POST["ville"] : "";
$codePostal = isset($_POST["codePostal"]) ? $_POST["codePostal"] : "";
$pays = isset($_POST["pays"]) ? $_POST["pays"] : "";
$telephone = isset($_POST["telephone"]) ? $_POST["telephone"] : "";
$carteEtudiant = isset($_POST["carteEtudiant"]) ? $_POST["carteEtudiant"] : "";
$typeCarte = isset($_POST["typeCarte"]) ? $_POST["typeCarte"] : "";
$numCarte = isset($_POST["numCarte"]) ? $_POST["numCarte"] : "";
$nomCarte = isset($_POST["nomCarte"]) ? $_POST["nomCarte"] : "";
$dateExpiration = isset($_POST["expiration"]) ? $_POST["expiration"] : "";
$cvv = isset($_POST["cvv"]) ? $_POST["cvv"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$pw = isset($_POST["password"]) ? $_POST["password"] : "";

//$mailLogin = isset($_POST["emailLogin"]) ? $_POST["emailLogin"] : "";
//$pwLogin = isset($_POST["passwordLogin"]) ? $_POST["passwordLogin"] : "";

$erreur = "";

if (!empty($_POST)) {

    if ($nom == "") {
        $erreur .= "Le champ nom est vide. <br>";
    }
    if ($prenom == "") {
        $erreur .= "Le champ prenom est vide. <br>";
    }
    if ($adresse == "") {
        $erreur .= "Le champ adresse est vide. <br>";
    }
    if ($ville == "") {
        $erreur .= "Le champ ville est vide. <br>";
    }
    if ($codePostal == "") {
        $erreur .= "Le champ codePostal est vide. <br>";
    }
    if ($pays == "") {
        $erreur .= "Le champ pays est vide. <br>";
    }
    if ($telephone == "") {
        $erreur .= "Le champ telephone est vide. <br>";
    }
    if ($carteEtudiant == "") {
        $erreur .= "Le champ carteEtudiant est vide. <br>";
    }
    if ($typeCarte == "") {
        $erreur .= "Le champ typeCarte est vide. <br>";
    }
    if ($numCarte == "") {
        $erreur .= "Le champ numCarte est vide. <br>";
    }
    if ($nomCarte == "") {
        $erreur .= "Le champ nomCarte est vide. <br>";
    }
    if ($dateExpiration == "") {
        $erreur .= "Le champ dateExpiration est vide. <br>";
    }
    if ($cvv == "") {
        $erreur .= "Le champ cvv est vide. <br>";
    }
    if ($pw == "") {
        $erreur .= "Le champ password est vide. <br>";
    }
    if ($email == "") {
        $erreur .= "Le champ email est vide. <br>";
    }

    if ($erreur == "") {
        echo "Formulaire valide. <br>";
        $_SESSION["nom"] = $nom;
        $_SESSION["prenom"] = $prenom;
        $_SESSION["adresse"] = $adresse;
        $_SESSION["ville"] = $ville;
        $_SESSION["codePostal"] = $codePostal;
        $_SESSION["pays"] = $pays;
        $_SESSION["telephone"] = $telephone;
        $_SESSION["carteEtudiant"] = $carteEtudiant;
        $_SESSION["typeCarte"] = $typeCarte;
        $_SESSION["numCarte"] = $numCarte;
        $_SESSION["nomCarte"] = $nomCarte;
        $_SESSION["dateExpiration"] = $dateExpiration;
        $_SESSION["cvv"] = $cvv;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $pw;

        try {
            $user = creationCompte();
            if ($user == false) {
                $return = "Le compte n'a pas pu être créé, veullez saisir un autre email";
            }
        } catch (Exception $e) {
            echo "problème avec la méthode addUser : " . $e->getMessage();
        }
    } else {
        echo "Erreur :" . $erreur . ". <br>";
    }
}


?>


<body>

    <?php
    if (isset($user) && $user == true) {
        header('Location:connexion.php');
    } else {
        if (isset($return) && !empty($return)) {
            echo $return;
        }
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
    }
    ?>

    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg></span><span>Omnes Sports</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-6"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse flex-grow-0 order-md-first" id="navcol-6">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                </ul>
                <div class="d-md-none my-2"><button class="btn btn-light me-2" type="button">Button</button><button class="btn btn-primary" type="button">Button</button></div>
            </div>
            <div class="d-none d-md-block"></div>
        </div>
    </nav>
    <div class="row register-form">
        <div class="col-md-8 offset-md-2">
            <form class="custom-form" action="inscription.php" method="POST">
                <h1>Inscription</h1>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Nom</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="nom"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Prénom</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="prenom"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="email-input-field">Email </label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="email" name="email"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="pawssword-input-field">Mot de passe</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="password" name="password"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Adresse</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="adresse"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Ville</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="ville"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Code postal</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="codePostal"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Pays</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="pays"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Carte étudiante</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="carteEtudiant"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Téléphone</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="telephone" maxlength="10"></div>
                </div>
                <div id="separation"></div>
                <h1 style="margin-top: 20px;">Informations carte</h1>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Nom sur la carte</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" name="nomCarte"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Type de carte</label></div>
                    <div class="col-sm-6 input-column">
                        <select class="form-select" name="typeCarte">
                            <optgroup label="Choisir">
                                <option value="Mastercard" selected>MASTERCARD</option>
                                <option value="Visa">VISA</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Numéro carte</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" maxlength="16" name="numCarte"></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Date d'expiration</label></div>
                    <div class="col-sm-6 input-column"><input type="month" id="datefield1" name="expiration" value="min" min="2018-01-01" max="2025-12-31">
                        <script>
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();

                            if (dd < 10) {
                                dd = '0' + dd;
                            }

                            if (mm < 10) {
                                mm = '0' + mm;
                            }

                            today = yyyy + '-' + mm + '-' + dd;
                            document.getElementById("datefield1").setAttribute("min", today);
                        </script>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">CVV</label></div>
                    <div class="col-sm-6 input-column"><input class="form-control" type="text" maxlength="3" name="cvv"></div>
                </div><button class="btn btn-light submit-button" type="submit">S'inscrire</button><a href="connexion.php"><button id="connect" class="btn btn-light" type="button">Se connecter</button></a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="assets/js/Lightbox-Gallery.js"></script>
    <script src="assets/js/Table-With-Search.js"></script>


</html>