<?php
session_start();
require_once("traitementInscription.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Se connecter</title>
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





$erreur = "";

if (!empty($_POST)) {
    $mailLogin = isset($_POST["email"]) ? $_POST["email"] : "";
    $pwLogin = isset($_POST["password"]) ? $_POST["password"] : "";
    $typeCompte = isset($_POST["typeCompte"]) ? $_POST["typeCompte"] : "";

    $_SESSION["type"] = $typeCompte;
    if ($pwLogin == "") {
        $erreur .= "Le champ password est vide. <br>";
    }
    if ($mailLogin == "") {
        $erreur .= "Le champ email est vide. <br>";
    }
    if ($typeCompte == "") {
        $erreur .= "Le champ type de compte est vide. <br>";
    }

    if ($erreur == "") {
        echo "Formulaire valide. <br>";
        $_SESSION["email"] = $mailLogin;
        $_SESSION["password"] = $pwLogin;


        $log = logIn();
        if ($log == false) {
            echo "Email ou mot de passe incorrect";
        } else {
            if ($typeCompte == "client") {
                header("Location: client/Accueil.php");
            }
            if ($typeCompte == "coach") {
                header("Location: coach/compteCoach.php");
            }
        }
    } else {
        echo "Erreur :" . $erreur . ". <br>";
    }
}


?>

<body>
    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg class="bi bi-bezier" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg></span><span>Omnes Sports</span></a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-6"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div id="navcol-6" class="collapse navbar-collapse flex-grow-0 order-md-first">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                </ul>
                <div class="d-md-none my-2"><button class="btn btn-light me-2" type="button">Button</button><button class="btn btn-primary" type="button">Button</button></div>
            </div>
            <div class="d-none d-md-block"></div>
        </div>
    </nav>
    <section class="position-relative py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Se connecter</h2>
                    <p class="w-lg-50"></p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4"><svg class="bi bi-person" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                                </svg></div>
                            <form class="text-center" action="connexion.php" method="post">
                                <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email" /></div>
                                <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" /></div>
                                <div class="col-xl-11">
                                    <select class="form-select" name="typeCompte">
                                        <optgroup label="Choisir">
                                            <option value="coach" selected>Coach</option>
                                            <option value="client">Client</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Se connecter</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>