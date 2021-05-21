<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="" />
    <title>Veltins Dashboard</title>
    <!-- CSS Link -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Datepicker CDN -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-date-range-picker/0.14.2/daterangepicker.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <!-- jQueyr CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- Bootstarp JS CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-date-range-picker/0.14.2/jquery.daterangepicker.min.js'>
    </script>

</head>

<body>
    <div class="grid-container">
        <div class="item0">
            <div id="sticky-sidebar">
                <div class="sticky-top">
                    <div class="sticky"></div>
                    <div class="logo">
                        <img src="./images/logo_1.png" alt="" srcset="">
                    </div>
                    <div class="dashbrd">
                        <p>
                            <img class="squars" src="./images/union.png" alt="" srcset="">
                            Dashboard
                        </p>
                    </div>
                    <div class="logout">
                        <p>Logout</p>
                    </div>
                    <output></output>
                </div>
            </div>
        </div>
        <div class="item1 unselectable">
            <h1>Dashboard</h1>
            <p id="menu" onclick="myFunction()" class="dropbtn" title="Aktion-Liste">Adventskalender <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 1L4.5 4L1 1" stroke="#096C30" />
                </svg></p>
            <div id="myDropdown" class="dropdown-content">
            </div>
            <p></p>

            <p class="popup-opener"><img style="width: 20px;margin:0px 0 0 30px;" src="images/add.png" alt="Neue Aktion Hinzufügen" title="Neue Aktion Hinzufügen" srcset=""></p>
            <div id="popup-overlay">
                <div id="popup-tablecellWrap">
                    <div id="popup-closer"></div>
                    <div id="popup-wrapper">
                        <div class="popup-content">

                            <h2 class="popup-title">Neuen Kalender Hinzufügen</h2>

                            <div class="popup-form">
                                <input id="newAct" type="text" name="form-name" class="popup-form-field" placeholder="Name der Aktion" maxlength="50" pattern="^[A-Za-z]+$" required>

                                <button onclick="addAction()" class="popup-form-submit">Senden</button>
                                <p id="warten"></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="dateElements">
                <div id="datumAuswählen" class="timeButons">
                    <span id="sp">Datum Auswählen</span>
                    <span id='i' class="fa fa-calendar"></span>
                    <div style='width: 12em;position: relative;right: 1vw;top: 15px;' id='ccc'></div>
                </div>

                <div id="aktuelleWoche" onclick="getNumbers(this.id)" class="timeButons">Aktuelle Woche</div>
                <div id="letzteWoche" onclick="getNumbers(this.id)" class="timeButons">Letzte Woche</div>
                <div id="gestern" onclick="getNumbers(this.id)" class="timeButons">Gestern</div>
                <div id="heute" onclick="getNumbers(this.id)" class="timeButons">Heute</div>
                <div id="ganzeAktion" onclick="getNumbers(this.id)" class="timeButons active" id="firstButton">Ganze
                    Aktion
                </div>
                <div class="clear"></div>
            </div>
            <hr>
        </div>

        <div class="item2 unselectable">
            <div class="gesamtzahl box">
                <div class="teilnehmer">
                    <div id="gesamtTeilnehmer" class="zahl">

                    </div>
                    <div class="caption">Gezamtzahl Teilnehmer</div>
                </div>
                <div class="group">
                    <img src="./images/group.png" alt="">
                </div>
            </div>
            <div class="gesamtzahl box">
                <div class="teilnehmer">
                    <div id="gerubbelterFelder" class="zahl">
                    </div>
                    <div class="caption">Gezamtzahl gerubbelter Felder</div>
                </div>
                <div class="group">
                    <img src="./images/Vector.png" alt="">
                </div>
            </div>
            <div class="gesamtzahl box">
                <div class="teilnehmer">
                    <div id="teilnehmerHeute" class="zahl"></div>
                    <div id="teilnehmerText" class="caption">Teilnehmer Heute</div>
                </div>
                <div class="group">
                    <img src="./images/group2.png" alt="">
                </div>
            </div>
        </div>
        <div class="item3">Aktivität

            <table id="activityTable" class="tableCommon table table-striped table-earning">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>User pro Tag</th>
                        <th>Neue Adressdaten pro Tag</th>
                        <th>Anzahl gerubbelter Felder</th>
                        <th>Gesamt gerubbleter Felder</th>
                        <th>Gesamt Teilnehmer</th>
                    </tr>
                </thead>
                <tbody id="testBody"></tbody>
            </table>

        </div>
        <div class="item4">
            <div class="geschlecht box">
                Geschlecht
                <canvas id="donutChart" width="300" height="300"></canvas>
            </div>
            <div class="alter box">
                Verteilung nach Alter
                <canvas id="barChart" width="700" height="300"></canvas>
            </div>
        </div>
        <div class="item5">Herkunft
            <div class="tbl">
                <table id="herkunftTable1" class="tableCommon table table-striped table-earning">
                    <thead>
                        <tr>
                            <th>Ort</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody id="herkunftBody1"></tbody>
                </table>
                <table id="herkunftTable2" class="tableCommon table table-striped table-earning">
                    <thead>
                        <tr>
                            <th>Ort</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody id="herkunftBody2"></tbody>
                </table>
            </div>
        </div>
        <div class="item6">
            <div class="av">
                Aktion Vergleichen
                <hr>
            </div>
            <div class="nutzer box">
                Neue Nutzer
                <canvas id="myChartNutzer"></canvas>
            </div>
            <div class="felder box">
                Anzahl gerubbelter Felder
                <canvas id="myChartFelder"></canvas>
            </div>
        </div>
    </div>
    <!-- JS -->
    <script src="./js.js"></script>
</body>

</html>