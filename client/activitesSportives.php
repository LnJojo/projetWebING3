<?php
session_start();
require_once("../traitementClient.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Projet Piscine</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../assets/css/Account-setting-or-edit-profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/Navbar-Centered-Links.css">
    <link rel="stylesheet" href="../assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/Table-With-Search-1.css">
    <link rel="stylesheet" href="../assets/css/Table-With-Search.css">
</head>

<body>
    <?php
    if (!empty($_POST)) {                                   ///Si on appuie sur un bouton
        if (isset($_POST['prendreRDV'])) {                  ///Si on prend rdv avec le coach affiche sur la page
            priseRdv($_SESSION["id"], $_POST['idRDV']);
        }
        if (isset($_POST['VoirRDV'])) {                     ///Si on appuie sur le bouton pour voir les rdv du coach selectionne
            $_SESSION["specialite"] = $_POST['specialite'];   ///On recupere la specialite 
            header("Location: autreCoachs.php");            ///On va sur la prochaine page qui affiche les differents coachs de la specialite
        }
        if (isset($_POST['search'])) {                      ///Si on appuie sur le bouton rechercher dans la navbar
            $search = $_POST['text'];
            if (checkSearch($search)) {                       ///On check si la recherche de specialite est valide
                $_SESSION["specialite"] = $_POST['text'];     ///On va sur une page si c'est valide
                header("Location: search.php");
            }
            if (checkSearchNomPrenom($search)) {

                $_SESSION["typeSearch"] = "nom";
                $_SESSION["specialite"] = $_POST['text'];
                //echo $_SESSION["typeSearch"] . $_SESSION["specialite"];
                header("Location: search.php");
            } else {
                header("Refresh: activitesSportives.php");  ///Sinon on refresh la page actuelle
            }
        }
    }

    ?>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg></span><span>Omnes Sports</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active link-primary" href="Accueil.php">Accueil</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Tout parcourir</a>
                        <div class="dropdown-menu"><a class="dropdown-item" href="activitesSportives.php">Activités sportives</a><a class="dropdown-item" href="SportsCompetition.php">Sports de compétitions</a><a class="dropdown-item" href="salleDeSport.php">Salle de sport Omnes</a></div>
                    </li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="rendez-vous.php">Rendez-vous</a></li>
                    <li class="nav-item"><a class="nav-link" href="votreCompte.php">Votre compte</a></li>
                </ul>
                <form method="POST" action="activitesSportives.php"><input type="search" name="text"><button class="btn btn-primary" type="submit" name="search">Rechercher</button></form>
            </div>
        </div>
    </nav>
    <div id="musculation">
        <div></div>
        <h1>Musculation</h1>
        <div style="text-align: left;padding: 20px;"><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-1" href="#collapse-1" role="button">En savoir plus</a>
            <div class="collapse" id="collapse-1">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4"><img src="../assets/img/Coachs/coach%20muscu%20image.jpg"></div>
                        <div class="col">
                            <h1 style="text-align: center;font-weight: bold;font-size: 36px;">Coach musculation</h1>
                            <h2 style="color: rgb(255,255,255);">Jean Lasalle</h2><button class="btn btn-primary" type="button">Voir CV</button>
                        </div>
                        <div class="col">
                            <h3 style="color: rgb(255,255,255);text-align: left;">Tel. : 06 00 00 00 00</h3>
                            <h4 style="color: rgb(255,255,255);text-align: left;">Mail : Jean.lasalle@edu.ece.fr</h4><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal1">Prendre rendez-vous</button>
                            <div class="modal fade" role="dialog" tabindex="-1" id="modal1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Rendez-vous</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"><input type="date" id="datefield1" name="dateRdv1" value="min" min="2018-01-01" max="2025-12-31">
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

                                                $('#datefield1').on("change", function() {
                                                    var date = $(this).val();
                                                    $.ajax({
                                                        url: "../traitementClient.php", // Valeur va etre renvoyée a action.php
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            dateRdv1: date


                                                        },
                                                        success: function(data) {
                                                            $("#Rdv1").html(data);
                                                        }
                                                    });

                                                    closeDate(this);
                                                });
                                            </script>
                                            <div class="table-responsive">
                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>Rendez-vous disponible(s)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div id="Rdv1">

                                                        </div>
                                                    </tbody>
                                                    <?php
                                                    //$date = isset($_POST["dateRdv"]) ?$_POST["dateRdv"] : "";
                                                    //afficherRdv(1,$date);
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method='post' action='activitesSportives.php' style='background-color :rgba(44,49,52,0.75);'>
                    <button class="btn btn-primary" type="submit" name="VoirRDV">Voir d'autres coachs</button>
                    <input type='hidden' value='musculation' name='specialite' />
                </form>
            </div>
        </div>
    </div>
    <div id="fitness">
        <div></div>
        <h1>Fitness</h1>
        <div style="text-align: left;padding: 20px;"><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-3" href="#collapse-3" role="button">En savoir plus</a>
            <div class="collapse" id="collapse-3">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4"><i class="far fa-user" style="font-size: 145px;color: rgb(255,255,255);"></i></div>
                        <div class="col">
                            <h1 style="text-align: center;font-weight: bold;font-size: 36px;">Coach Fitness</h1>
                            <h2 style="color: rgb(255,255,255);">Jean Fitness</h2><button class="btn btn-primary" type="button">Voir CV</button>
                        </div>
                        <div class="col">
                            <h3 style="color: rgb(255,255,255);text-align: left;">Tel. : 06 00 00 00 00</h3>
                            <h4 style="color: rgb(255,255,255);text-align: left;">Mail : Jean.fitness@omnessport.fr</h4><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal2">Prendre rendez-vous</button>
                            <div class="modal fade" role="dialog" tabindex="-1" id="modal2">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Rendez-vous</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"><input type="date" id="datefield2" name="dateRdv2" value="min" min="2018-01-01" max="2025-12-31">
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
                                                document.getElementById("datefield2").setAttribute("min", today);

                                                $('#datefield2').on("change", function() {
                                                    var date = $(this).val();
                                                    $.ajax({
                                                        url: "../traitementClient.php", // Valeur va etre renvoyée a action.php
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            dateRdv2: date

                                                        },
                                                        success: function(data) {
                                                            $("#Rdv2").html(data);
                                                        }
                                                    });

                                                    closeDate(this);
                                                });
                                            </script>
                                            <div class="table-responsive">
                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>Rendez-vous disponible(s)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div id="Rdv2">

                                                        </div>
                                                    </tbody>
                                                    <?php
                                                    //$date = isset($_POST["dateRdv"]) ?$_POST["dateRdv"] : "";
                                                    //afficherRdv(1,$date);
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method='post' action='activitesSportives.php' style='background-color :rgba(44,49,52,0.75);'>
                    <button class="btn btn-primary" type="submit" name="VoirRDV">Voir d'autres coachs</button>
                    <input type='hidden' value='fitness' name='specialite' />
                </form>
            </div>
        </div>
    </div>
    <div id="biking">
        <div></div>
        <h1>Biking</h1>
        <div style="text-align: left;padding: 20px;"><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-4" href="#collapse-4" role="button">En savoir plus</a>
            <div class="collapse" id="collapse-4">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4"><i class="far fa-user" style="font-size: 145px;color: rgb(255,255,255);"></i></div>
                        <div class="col">
                            <h1 style="text-align: center;font-weight: bold;font-size: 36px;">Coach Biking</h1>
                            <h2 style="color: rgb(255,255,255);">Jaylon Koelpin</h2><button class="btn btn-primary" type="button">Voir CV</button>
                        </div>
                        <div class="col">
                            <h3 style="color: rgb(255,255,255);text-align: left;">Tel. : 06 00 00 00 00</h3>
                            <h4 style="color: rgb(255,255,255);text-align: left;">Mail : jaylon.koelpin@omnessport.fr</h4><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-3">Prendre rendez-vous</button>
                            <div class="modal fade" role="dialog" tabindex="-1" id="modal-3">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Rendez-vous</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"><input type="date" id="datefield3" name="dateRdv3" value="min" min="2018-01-01" max="2025-12-31">
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
                                                document.getElementById("datefield3").setAttribute("min", today);

                                                $('#datefield3').on("change", function() {
                                                    var date = $(this).val();
                                                    $.ajax({
                                                        url: "../traitementClient.php", // Valeur va etre renvoyée a action.php
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            dateRdv3: date

                                                        },
                                                        success: function(data) {
                                                            $("#Rdv3").html(data);
                                                        }
                                                    });

                                                    closeDate(this);
                                                });
                                            </script>
                                            <div class="table-responsive">
                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>Rendez-vous disponible(s)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div id="Rdv3">

                                                        </div>
                                                    </tbody>
                                                    <?php
                                                    //$date = isset($_POST["dateRdv"]) ?$_POST["dateRdv"] : "";
                                                    //afficherRdv(1,$date);
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method='post' action='activitesSportives.php' style='background-color :rgba(44,49,52,0.75);'>
                    <button class="btn btn-primary" type="submit" name="VoirRDV">Voir d'autres coachs</button>
                    <input type='hidden' value='biking' name='specialite' />
                </form>
            </div>
        </div>
    </div>
    <div id="cardio-training">
        <div></div>
        <h1>Cardio training</h1>
        <div style="text-align: left;padding: 20px;"><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-5" href="#collapse-5" role="button">En savoir plus</a>
            <div class="collapse" id="collapse-5">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4"><i class="far fa-user" style="font-size: 145px;color: rgb(255,255,255);"></i></div>
                        <div class="col">
                            <h1 style="text-align: center;font-weight: bold;font-size: 36px;">Coach Cardio-Training</h1>
                            <h2 style="color: rgb(255,255,255);">Wilfred Lockman</h2><button class="btn btn-primary" type="button">Voir CV</button>
                        </div>
                        <div class="col">
                            <h3 style="color: rgb(255,255,255);text-align: left;">Tel. : 06 00 00 00 00</h3>
                            <h4 style="color: rgb(255,255,255);text-align: left;">Mail : wilfred.lockman@edu.ece.fr</h4><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-4">Prendre rendez-vous</button>
                            <div class="modal fade" role="dialog" tabindex="-1" id="modal-4">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Rendez-vous</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"><input type="date" id="datefield4" name="dateRdv3" value="min" min="2018-01-01" max="2025-12-31">
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
                                                document.getElementById("datefield4").setAttribute("min", today);

                                                $('#datefield4').on("change", function() {
                                                    var date = $(this).val();
                                                    $.ajax({
                                                        url: "../traitementClient.php", // Valeur va etre renvoyée a action.php
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            dateRdv4: date

                                                        },
                                                        success: function(data) {
                                                            $("#Rdv4").html(data);
                                                        }
                                                    });

                                                    closeDate(this);
                                                });
                                            </script>
                                            <div class="table-responsive">
                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>Rendez-vous disponible(s)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div id="Rdv4">

                                                        </div>
                                                    </tbody>
                                                    <?php
                                                    //$date = isset($_POST["dateRdv"]) ?$_POST["dateRdv"] : "";
                                                    //afficherRdv(1,$date);
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method='post' action='activitesSportives.php' style='background-color :rgba(44,49,52,0.75);'>
                    <button class="btn btn-primary" type="submit" name="VoirRDV">Voir d'autres coachs</button>
                    <input type='hidden' value='cardio-training' name='specialite' />
                </form>
            </div>
        </div>
    </div>
    <div id="group-training">
        <div></div>
        <h1>Group training</h1>
        <div style="text-align: left;padding: 20px;"><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-6" href="#collapse-6" role="button">En savoir plus</a>
            <div class="collapse" id="collapse-6">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4"><i class="far fa-user" style="font-size: 145px;color: rgb(255,255,255);"></i></div>
                        <div class="col">
                            <h1 style="text-align: center;font-weight: bold;font-size: 36px;">Coach Group-Training</h1>
                            <h2 style="color: rgb(255,255,255);">Augustine Littel</h2><button class="btn btn-primary" type="button">Voir CV</button>
                        </div>
                        <div class="col">
                            <h3 style="color: rgb(255,255,255);text-align: left;">Tel. : 06 00 00 00 00</h3>
                            <h4 style="color: rgb(255,255,255);text-align: left;">Mail : augustine.littel@omnessport.fr</h4><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-5">Prendre rendez-vous</button>
                            <div class="modal fade" role="dialog" tabindex="-1" id="modal-5">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Rendez-vous</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"><input type="date" id="datefield5" name="dateRdv3" value="min" min="2018-01-01" max="2025-12-31">
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
                                                document.getElementById("datefield5").setAttribute("min", today);

                                                $('#datefield5').on("change", function() {
                                                    var date = $(this).val();
                                                    $.ajax({
                                                        url: "../traitementClient.php", // Valeur va etre renvoyée a action.php
                                                        type: "POST",
                                                        cache: false,
                                                        data: {
                                                            dateRdv5: date

                                                        },
                                                        success: function(data) {
                                                            $("#Rdv5").html(data);
                                                        }
                                                    });

                                                    closeDate(this);
                                                });
                                            </script>
                                            <div class="table-responsive">
                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>Rendez-vous disponible(s)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div id="Rdv5">

                                                        </div>
                                                    </tbody>
                                                    <?php
                                                    //$date = isset($_POST["dateRdv"]) ?$_POST["dateRdv"] : "";
                                                    //afficherRdv(1,$date);
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method='post' action='activitesSportives.php' style='background-color :rgba(44,49,52,0.75);'>
                    <button class="btn btn-primary" type="submit" name="VoirRDV">Voir d'autres coachs</button>
                    <input type='hidden' value='group-training' name='specialite' />
                </form>
            </div>
        </div>
    </div>
    <footer class="text-white bg-dark">
        <div class="container py-4 py-lg-5">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
                    <h3 class="fs-6 text-white">Tout parcourir</h3>
                    <ul class="list-unstyled">
                        <li><a class="link-light" href="#">Activités sportives</a></li>
                        <li><a class="link-light" href="#">Sports de compétitions</a></li>
                        <li><a class="link-light" href="#">Salle de sport Omnes</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
                    <h3 class="fs-6 text-white">Sports de compétition</h3>
                    <ul class="list-unstyled">
                        <li><a class="link-light" href="#">Basketball</a></li>
                        <li><a class="link-light" href="#">Football</a></li>
                        <li><a class="link-light" href="#">Rugby</a></li>
                        <li><a class="link-light" href="#">Tennis</a></li>
                        <li><a class="link-light" href="#">Natation</a></li>
                        <li><a class="link-light" href="#">Plongeon</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 text-center text-lg-start d-flex flex-column item">
                    <h3 class="fs-6 text-white">Votre compte</h3>
                    <ul class="list-unstyled">
                        <li><a class="link-light" href="#">Mon compte</a></li>
                        <li><a class="link-light" href="#">Mes rendez-vous</a></li>
                        <li><a class="link-light" href="#"></a></li>
                        <li><a class="link-light" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-lg-3 text-center text-lg-start d-flex flex-column align-items-center order-first align-items-lg-start order-lg-last item social">
                    <div class="fw-bold d-flex align-items-center mb-2"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier fs-5">
                                <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                                <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                            </svg></span><span>Omnes Sports</span></div>
                    <p class="text-muted copyright"></p>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center pt-3">
                <p class="mb-0">Copyright © 2022 Omnes Sports</p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                        </svg></li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
    <script src="../assets/js/Lightbox-Gallery.js"></script>
    <script src="../assets/js/Table-With-Search.js"></script>
</body>

</html>