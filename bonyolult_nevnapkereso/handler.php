<?php
// 13. feladat: Az API használata az űrlap adataival 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nap = $_POST['nap'] ?? '';
    $nev = $_POST['nev'] ?? '';

    // Az API végpontja [cite: 201]
    $apiUrl = "http://localhost/nevnap/api/";
    $params = "";
    $mod = "";

    if (!empty($nev)) {
        $params = "?nev=" . urlencode($nev);
        $mod = "nev";
    } elseif (!empty($nap)) {
        $params = "?nap=" . urlencode($nap);
        $mod = "nap";
    }

    // API hívás végrehajtása
    $response = file_get_contents($apiUrl . $params);


    // Visszaküldés a főoldalra az adatokkal
    header("Location: index.php?data=" . urlencode($response) . "&mod=" . $mod);
    exit;
}