<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YouGo | Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="./vendor/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="./vendor/waves/waves.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script onerror="console.log('Erreur chargement dashboard.js')" onload="console.log('Chargement de dashboard.js réussi')" src="js/dashboard.js"></script>
    <script>

    </script>
    <?php include("functions.php"); ?>
</head>
<body>

<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>

<div id="main-wrapper">
    <?php
    if(isset($_POST['venue_name'])){
        $name_post = $_POST['venue_name'];
        $address_post = $_POST['venue_address'];
        $pick_day = 90;
        $hour_open = 0;
        $tab_api_yougo = get_venue_all($address_post);
        ?>
        <script>
            let tab_values_1 = [0, 0, 0, 25, 35, 15, 35, 50, 90, 80, 30, 20, 0, 0, 0, 25, 35, 15, 35, 50, 75, 80, 30, 20];
            let tab_values_2 = [0, 0, 0, 25, 35, 15, 35, 50, 90, 80, 30, 20, 0, 0, 0, 25, 35, 15, 35, 50, 75, 0, 30, 20];
            let tab_values_3 = [0, 0, 0, 25, 35, 15, 35, 50, 90, 80, 30, 20, 0, 0, 0, 25, 35, 15, 35, 50, 75, 20, 30, 20];
        </script>
    <?php
    }
    else{
        $name_post = $_GET['venue_name'];
        $address_post = $_GET['venue_address'];
        $tab_horaire_monday = $_GET['monday'];
        $tab_horaire_tuesday = $_GET['tuesday'];
        $tab_horaire_wednesday = $_GET['wednesday'];
        $tab_horaire_thursday = $_GET['thursday'];
        $tab_horaire_friday = $_GET['friday'];
        $tab_horaire_saturday = $_GET['saturday'];
        $tab_horaire_sunday = $_GET['sunday'];
        $pick_day = max(explode(",", $tab_horaire_monday));
        $hour_open = heureOuverture(explode(",", $tab_horaire_monday));
        $tab_api_yougo = null;
        ?>
        <script>
            let tab_values_1 = [<?php echo $tab_horaire_monday ?>];
            let tab_values_2 = [<?php echo $tab_horaire_tuesday ?>];
            let tab_values_3 = [<?php echo $tab_horaire_wednesday ?>];
            let tab_values_4 = [<?php echo $tab_horaire_thursday ?>];
            let tab_values_5 = [<?php echo $tab_horaire_friday ?>];
            let tab_values_6 = [<?php echo $tab_horaire_saturday ?>];
            let tab_values_7 = [<?php echo $tab_horaire_sunday ?>];
        </script>
    <?php }
    $venue_id = "";
    $venue_name = "";
    $venue_address = "";
    $venue_lon = "";
    $venue_lat = "";
    $venue_timezone = "";
    $venue_tag = "";
    if($tab_api_yougo == null){?>
        <script>console.log("API_BESTTIME");</script>
        <?php
        if(isset($_POST['venue_name'])){
            get_api_bestime($_POST['venue_name'], $_POST['venue_address']);?>
            <div id="preloader">
                <div class="sk-three-bounce">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>
        <?php
        }
        else{
        $venue_name = $_GET['venue_name'];
        $venue_address = $_GET['venue_address'];
        $venue_lon = $_GET['venue_lon'];
        $venue_lat = $_GET['venue_lat'];
        $venue_timezone = $_GET['venue_timezone'];
        $venue_tag = $_GET['venue_type'];
        $venue_id = add_venue($venue_address, $venue_name, $venue_lon, $venue_lat, $venue_timezone);
        $venue_id = $venue_id["venue_id"];

        $competur = 0;

        get_api_bestime2($venue_id, $venue_name, $venue_address);
        }
    }
    else{?>
        <script>console.log("API_YOUGO");</script>
        <?php
        foreach ($tab_api_yougo as $data_venue){
            $venue_id = $data_venue['venue_id'];
            $venue_name = $data_venue['venue_name'];
            $venue_address = $data_venue['venue_address'];
            $venue_lon = $data_venue['venue_lon'];
            $venue_lat = $data_venue['venue_lat'];
            $venue_timezone = $data_venue['venue_timezone'];
            $venue_tag = $data_venue['venue_tag'];
        }
    }?>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="navigation">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="index.html"><img src="./images/logo.png" alt=""></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.html">Accueil</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-title dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-title-content">
                        <p>Bienvenue
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-xxl-12">
                    <div class="card balance-widget">
                        <div class="card-header border-0 py-0">
                            <h4 class="card-title">Votre recherche</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="balance-widget">
                                <div class="total-balance">
                                    <h3><?php echo $venue_name; ?></h3>
                                    <h6>Détails</h6>
                                </div>
                                <ul class="list-unstyled">
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="m-0">Adresse</h5>
                                        </div>
                                        <div class="text-right">
                                            <h5><?php echo $venue_address; ?></h5>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="m-0">Timezone</h5>
                                        </div>
                                        <div class="text-right">
                                            <h5><?php echo $venue_timezone;?></h5>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="m-0">Latitude/longitude</h5>
                                        </div>
                                        <div class="text-right">
                                            <h5><?php echo $venue_lat."/".$venue_lon;?></h5>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <h5 class="m-0">Type</h5>
                                        </div>
                                        <div class="text-right">
                                            <h5><?php echo $venue_tag;?></h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-8 col-xxl-12">
                    <div class="card profile_chart">
                        <div class="card-header py-0">
                            <div class="duration-option">
                                <a id="lundi" class="day active">Lundi</a>
                                <a id="mardi" class="day">Mardi</a>
                                <a id="mercredi" class="day">Mercredi</a>
                                <a id="jeudi" class="day">Jeudi</a>
                                <a id="vendredi" class="day">Vendredi</a>
                                <a id="samedi" class="day">Samedi</a>
                                <a id="dimanche" class="day">Dimanche</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="timeline-chart"></div>
                            <div class="chart-content text-center">
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6 col-6">
                                        <div class="chart-stat">
                                            <p class="mb-1">Pick journalier</p>
                                            <h5 id="pick_day"><?php echo $pick_day; ?>%</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-6 col-6">
                                        <div class="chart-stat">
                                            <p class="mb-1">Heures de pointe</p>
                                            <h5>19h-22h</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-6 col-6">
                                        <div class="chart-stat">
                                            <p class="mb-1">Heures calme</p>
                                            <h5>15h-18h</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-6 col-6">
                                        <div class="chart-stat">
                                            <p class="mb-1">Ouverture/Fermeture</p>
                                            <h5 id="hour_open" ><?php echo $hour_open; ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-xl-9 col-lg-8 col-xxl-12">
                    <div class="card">
                        <div class="card-header border-0 py-0">
                            <h4 class="card-title">Historique de recherche</h4>
                            <a href="#">Voir +</a>
                        </div>
                        <div class="card-body">
                            <div class="transaction-table">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-responsive-sm">
                                        <tbody>
                                        <tr>
                                            <td>Starbucks</td>
                                            <td>Aéroport Orly Ouest, 94310 Orly</td>
                                            <td><a href="#" style="color: white;" class="btn btn-primary">Détails</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>

    <div class="footer dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <div class="copyright">
                        <p>© Copyright 2022 <a href="#">ESGI</a> I All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="footer-social">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="./js/global.js"></script>

<script src="./vendor/waves/waves.min.js"></script>

<script src="./vendor/circle-progress/circle-progress.min.js"></script>
<script src="./vendor/circle-progress/circle-progress-init.js"></script>


<!--  flot-chart js -->
<script src="./vendor/apexchart/apexcharts.min.js"></script>
<script src="./vendor/apexchart/apexchart-init.js"></script>


<!-- <script src="./js/dashboard.js"></script> -->
<script src="./js/dashboard.js"></script>
<script src="./js/scripts.js"></script>
</body>

</html>