<?php
    if(!empty($_POST)){
        $dbHost = "microhomeserver";
        $dbName = "sensoren";
        $dbUser = "sensor_user";
        $dbPass = "sensor_user";
        $dbConfig = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        try {
            $link = new PDO('mysql:host='.$dbHost.';dbName='.$dbName, $dbUser, $dbPass, $dbConfig);
            $link->query("USE sensoren");
        } catch (Exception $ex1) {
            die('Could not establish the connection. '.$ex1);
        }

        //(str_contains($_POST['sql_command'], ';')) ? $res = $link->query($_POST['sql_command']) : $res = $link->query($_POST['sql_command'].';');
        if(strpos($_POST['sql_command'], ';') === FALSE){
            $stmt = $link->prepare($_POST['sql_command'].';');
            $stmt->execute();
        } else {
            $stmt->prepare($_POST['sql_command']);
            $stmt->execute();
        }
        if(isset($link)){
            $res = $stmt->fetchAll();
        }
    }
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MySQL-Scraper</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="main.css">
    </head>
    <body class="bg-dark text-light">
        <div class="container text-center">
            <h2>ScraperMyAdmin</h2>
            <span>Alle Datenbankeinträge</span>
        </div>

        <div class="container-fluid">
            <hr>

            <div class="row">
                <div class="col-3 border-end border-light">
        	        <h4>Command Line</h4>
                    <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="form-floating text-dark">
                            <textarea name="sql_command" id="floatingLabel1" class="form-control" style="height: 200%;"></textarea>
                            <label for="floatingLabel1">MySQL-Command</label>
                        </div>
                        <div class="w-100" style="height: 1em;"></div>
                        <button type="submit" class="btn btn-outline-light">Abfrage starten</button>
                    </form>
                </div>
                <div class="col-9">
                    <h4>Output <?php (!empty($_POST)) ? print_r(' &raquo; '.$_POST['sql_command']) : print_r(''); ?></h4>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Timestamp</th>
                                <th scope="col">Value in mV</th>
                                <th scope="col">Berechneter Wert in V <small>(von 3V)</small></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(isset($res)){
                                foreach ($res as $key) {
                                    $calc = $key['messwert'] / 1000;
                                    echo '
                                        <tr>
                                            <th scope="col">'.$key['id'].'</th>
                                            <td>'.$key['zeitstempel'].'</td>
                                            <td>'.$key['messwert'].'</td>
                                            <td>'.$calc.'</td>
                                        </tr>
                                    ';
                                }
                                // print_r($res);
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>