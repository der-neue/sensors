<?php
    /**
     * File: index.php
     * Author: PreTooo
     * Date: 2021-05-01, 15:52:18
     */
    require_once 'assets/php/dbConn.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sensors</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    </head>
    <body class="bg-dark text-light">
        <div class="w-100" style="height: 1em;"></div>
        <div class="container-fluid">
            <div class="text-center">
                <h2>Alle Sensoren</h2>
                <span>Wähle deinen Sensor aus um dir die Messwerte anzuschauen.</span>
                <hr>
            </div>
        </div>
        <div class="container-fluid px-4 text-center">
            <div class="row gx-5">
                <?php
                    $stmt = $dbHandler->prepare("SHOW TABLES");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    
                    foreach ($result as $key) {
                        ?>
                        <div class="col-3">
                            <a href="chart.php?id=<?php echo $key['Tables_in_sensoren'] ?>" class="text-light">
                                <div class="p-3 border rounded border-white">
                                    <h3><?php echo $key['Tables_in_sensoren'] ?></h3>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </body>
</html>