<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){


    $nev = $_POST["nev"] ?? '';
    $datum = $_POST["datum"] ?? '';

    $apiurl = "http://localhost/kozepes_nevnapkereso/api/";
    $param = "";

    if (!empty($nev)){
        $param = "?nev=" . $nev;
    }
    elseif(!empty($datum)){
        $param = "?datum=" . $datum;
    }


    $visszakapottertek = file_get_contents($apiurl . $param);
    $_SESSION["valasz"] = json_decode($visszakapottertek, true);

    header("location: index.php?lefutotte=igen");
}

?>