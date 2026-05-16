<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');

$db = mysqli_connect("localhost", "root", "", "nevnapok");

if (!$db){
    die("nem jó a kapcsolat");
}

mysqli_set_charset($db, "utf8mb4");

$honapok = ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];

if (!empty($_GET["nev"])) {
    $nev = $_GET["nev"];
    $lekerdezes = mysqli_query($db, "SELECT ho, nap, nev1, nev2 FROM nevnap WHERE nev1 = '$nev' || nev2 = '$nev' LIMIT 1");
    
    if (mysqli_num_rows($lekerdezes) > 0) {
        // {"datum":"április 30.","nevnap1":"Katalin","nevnap2":"Kitti"}
        
        $valasz = mysqli_fetch_assoc($lekerdezes);
        print json_encode([
            "datum" => $honapok[$valasz["ho"]-1] . " " . $valasz["nap"] . ".",
            "nevnap1" => $valasz["nev1"],
            "nevnap2" => $valasz["nev2"]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    else{
        print json_encode(["hiba" => "nincs találat"], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

elseif (!empty($_GET["nap"])) {
    $datum = explode("-", $_GET["nap"]);
    if (count($datum) < 2){
        print json_encode(["hiba" => "nincs találat"], JSON_UNESCAPED_UNICODE);
        exit;
    }
    else{
        $honap = $datum[0];
        $nap = $datum[1];
        $lekerdezes = mysqli_query($db, "SELECT ho, nap, nev1, nev2 FROM nevnap WHERE ho = '$honap' && nap = '$nap'");
        
        if (mysqli_num_rows($lekerdezes) > 0) {
            // {"datum":"április 30.","nevnap1":"Katalin","nevnap2":"Kitti"}
            
            $valasz = mysqli_fetch_assoc($lekerdezes);
            print json_encode([
                "datum" => $honapok[$valasz["ho"]-1] . " " . $valasz["nap"] . ".",
                "nevnap1" => $valasz["nev1"],
                "nevnap2" => $valasz["nev2"]
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
        else{
            print json_encode(["hiba" => "nincs találat"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}
else{
    // {"minta1":"/?nap=12-31","minta2":"/?nev=Szilveszter"}
    print json_encode([
        "minta1" => "/?nap=12-31",
        "minta2" => "/?nev=Szilveszter"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_close($db);
?>
