<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');


$db = mysqli_connect("localhost", "root", "", "nevnapok");

if (!$db){
    die("Hiba a csatlakozáskor");
}
mysqli_set_charset($db, "utf8mb4");

$honapok = ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];
$tomb = [];

if (!empty($_GET["nap"])){

    $datum = explode("-", $_GET["nap"]);
    $honap = $datum[0];
    $nap = $datum[1];
    
    $lekerdezes = mysqli_query($db, "SELECT nev1, nev2 FROM nevnap WHERE ho = '$honap' && nap = '$nap' ");

    if (mysqli_num_rows($lekerdezes) > 0){
        // {"datum":"április 30.","nevnap1":"Katalin","nevnap2":"Kitti"}
        $valasz = mysqli_fetch_assoc($lekerdezes);
        $tomb["datum"] = $honapok[$honap-1] . " " . $nap . ".";
        $tomb["nevnap1"] = $valasz["nev1"];

        if (!empty($valasz["nev2"])){
            $tomb["nevnap2"] = $valasz["nev2"];        
        }
    }else{
        // {"hiba":"nincs találat"}
        $tomb["hiba"] = "nincs találat";
    }
}
elseif (!empty($_GET["nev"])){

    $nev = $_GET["nev"];
    $lekerdezes = mysqli_query($db, "SELECT ho, nap FROM nevnap WHERE nev1 = '$nev' || nev2 = '$nev' LIMIT 1");

    if (mysqli_num_rows($lekerdezes) > 0){
        // {"datum":"április 30.","nevnap1":"Katalin","nevnap2":"Kitti"}
        $valasz = mysqli_fetch_assoc($lekerdezes);
        $tomb["datum"] = $honapok[$valasz["ho"]-1] . " " . $valasz["nap"] . ".";
        $tomb["nevnap1"] = $nev;

    }else{
        // {"hiba":"nincs találat"}
        $tomb["hiba"] = "nincs találat";
    }
}else{
    // {"minta1":"/?nap=12-31","minta2":"/?nev=Szilveszter"}
    $tomb["minta1"] = "/?nap=12-31";
    $tomb["minta2"] = "/?nev=Szilveszter";
}

print json_encode($tomb, JSON_UNESCAPED_UNICODE);

mysqli_close($db);
?>