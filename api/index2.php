<?php
error_reporting(E_ERROR | E_PARSE);
header('Content-Type: application/json; charset=utf-8');

$db = mysqli_connect("localhost", "root", "", "nevnapok");
mysqli_set_charset($db, "utf8mb4");

$honapok = ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];
$lekerdezes = false;

// 1. Keresés NÉV alapján
if (!empty($_GET["nev"])) {
    $nev = $_GET["nev"];
    $lekerdezes = mysqli_query($db, "SELECT ho, nap, nev1, nev2 FROM nevnap WHERE nev1 = '$nev' OR nev2 = '$nev' LIMIT 1");
} 
// 2. Keresés NAP alapján (Javítva a feladat szerinti ?nap= paraméterre!)
elseif (!empty($_GET["nap"])) {
    // Ha a formátum rossz (nincs kötőjel), a $ho és $nap változók üresek vagy nullok lesznek
    [$ho, $nap] = explode("-", $_GET["nap"]) + [null, null];
    $lekerdezes = mysqli_query($db, "SELECT ho, nap, nev1, nev2 FROM nevnap WHERE ho = '$ho' AND nap = '$nap'");
} 
// 3. Útmutató, ha nincs paraméter (7. feladat)
else {
    echo json_encode(["minta1" => "/?nap=12-31", "minta2" => "/?nev=Szilveszter"]);
    exit;
}

// 4. KÖZÖS MEGJELENÍTÉS ÉS HIBAKEZELÉS (5., 6. és 8. feladat)
if ($lekerdezes && mysqli_num_rows($lekerdezes) > 0) {
    $valasz = mysqli_fetch_assoc($lekerdezes);
    $tomb = [
        "datum" => $honapok[$valasz["ho"] - 1] . " " . $valasz["nap"] . ".",
        "nevnap1" => $valasz["nev1"],
        "nevnap2" => $valasz["nev2"]
    ];
} else {
    $tomb = ["hiba" => "nincs találat"];
}

echo json_encode($tomb, JSON_UNESCAPED_UNICODE);
mysqli_close($db);
?>