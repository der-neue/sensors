<?php
    /**
     * File: index.php
     * Author: PreTooo
     * Date: 2021-05-01, 15:52:18
     */
    require_once 'assets/php/dbConn.php';
    if(!empty($_GET['id'])){
        if(strpos($_GET['id'], ' ') === FALSE){
            $stmt = $dbHandler->prepare("SELECT * FROM ".$_GET['id']);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $stmt = $dbHandler->prepare("SELECT UNIX_TIMESTAMP() FROM ".$_GET['id']);
            $stmt->execute();
            $timestamps = $stmt->fetchAll();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sensors</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="bg-dark text-light">
        <div class="w-100" style="height: 1em;"></div>
        <div class="container-fluid">
            <div class="text-center">
                <h2><a href="index.php" class="text-light">Sensor</a> &raquo; <?php echo $_GET['id'] ?></h2>
                <hr>
            </div>
        </div>

        <div class="container-fluid centered">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="First group">
                    <button type="button" class="btn btn-outline-light" id="chart1">Temperatur + Luftfeuchtigkeit</button>
                    <button type="button" class="btn btn-outline-light" id="chart2">Batterie</button>
                </div>
                <div class="w-100" style="height: 1em;"></div>
                <div class="btn-group me-2" role="group" aria-label="Second group">
                    <button type="button" class="btn btn-outline-light" id="chart3">Heute</button>
                    <button type="button" class="btn btn-outline-light" id="chart4">Diese Woche</button>
                    <button type="button" class="btn btn-outline-light" id="chart5">Diesen Monat</button>
                    <button type="button" class="btn btn-outline-light" id="chart6">Gesamter Zeitraum</button>
                </div>
            </div>
        </div>
            <div class="w-100" style="height: 2em;"></div>
        <div class="container-fluid">
            <canvas id="chart" style="position: relative; height:40vh; width:80vw">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Canvas?</h4>
                    <hr>
                    <span>
                        Es sieht so aus, als würde dein Browser <code>Chart.JS</code>
                        nicht richtig laden können oder es blockieren.
                        <br>
                        Bitte benutze stattdessen Chrome oder Firefox.
                    </span>
                </div>
            </canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.0/dist/chart.min.js"></script>
        <script>
            var ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        <?php
                            // foreach ($result as $key) {
                            //     echo '"'.$key['zeitstempel'].'",';
                            // }
                            for ($i=sizeof($result)-20; $i < sizeof($result); $i++) { 
                                echo '"'. $result[$i]['zeitstempel'] .'",';
                            }
                        ?>
                    ],
                    datasets: [{
                        label: 'Temperatur in °C',
                        data: [
                            <?php
                                // foreach ($result as $key) {
                                //     echo '"'. $key['temperatur']/100 .'",';
                                // }
                                for ($i=sizeof($result)-20; $i < sizeof($result); $i++) { 
                                    echo '"'. $result[$i]['temperatur']/100 .'",';
                                }
                            ?>
                        ],
                        borderColor: 'rgb(243, 156, 18)',
                        tension: 0.25,
                        yAxisID: 'A',
                    },{
                        label: 'Luftfeuchtigkeit in %',
                        data: [
                            <?php 
                                for($i=sizeof($result)-20; $i < sizeof($result); $i++) {
                                    echo '"'. $result[$i]['luftfeuchte']/100 .'",';
                                }
                            ?>
                        ],
                        borderColor: 'rgb(236, 240, 241)',
                        tension: 0.25,
                        yAxisID: 'B',
                    }],
                },
                options: {
                    scales: {
                        'A': {
                            type: 'linear',
                            position: 'left'
                        },
                        'B': {
                            type: 'linear',
                            position: 'right'
                        }
                    },
                    layout: {
                        padding: {
                            right: 50
                        }
                    }
                }
            });

            document.querySelector('#chart2').addEventListener('click', () => {
                chart.config.data = {
                    labels: [
                        <?php
                            for ($i=sizeof($result)-20; $i < sizeof($result); $i++) { 
                                echo '"'. $result[$i]['zeitstempel'] .'",';
                            }
                        ?>
                    ],
                    datasets: [{
                        label: 'Batteriespannung in V',
                        data: [
                            <?php
                                for ($i=sizeof($result)-20; $i < sizeof($result); $i++) { 
                                    echo '"'. $result[$i]['batteriespannung'] .'",';
                                }
                            ?>
                        ],
                        borderColor : 'rgb(231, 76, 60)',
                        tension: .25,
                        yAxisID: 'A'
                    }]
                };
                chart.update();
            });
            document.querySelector('#chart1').addEventListener('click', () => {
                chart.config.data = {
                    labels: [
                        <?php
                            for ($i=sizeof($result)-20; $i < sizeof($result); $i++) { 
                                echo '"'. $result[$i]['zeitstempel'] .'",';
                            }
                        ?>
                    ],
                    datasets: [{
                        label: 'Temperatur in °C',
                        data: [
                            <?php
                                // foreach ($result as $key) {
                                //     echo '"'. $key['temperatur']/100 .'",';
                                // }
                                for ($i=sizeof($result)-20; $i < sizeof($result); $i++) { 
                                    echo '"'. $result[$i]['temperatur']/100 .'",';
                                }
                            ?>
                        ],
                        borderColor: 'rgb(243, 156, 18)',
                        tension: 0.25,
                        yAxisID: 'A',
                    },{
                        label: 'Luftfeuchtigkeit in %',
                        data: [
                            <?php 
                                for($i=sizeof($result)-20; $i < sizeof($result); $i++) {
                                    echo '"'. $result[$i]['luftfeuchte']/100 .'",';
                                }
                            ?>
                        ],
                        borderColor: 'rgb(236, 240, 241)',
                        tension: 0.25,
                        yAxisID: 'B',
                    }],
                };
                chart.update();
            });
        </script>
    </body>
</html>