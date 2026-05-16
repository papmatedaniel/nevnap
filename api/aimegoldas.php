<?php
header("Content-Type: application/json; charset=UTF-8");


// Adatbázis kapcsolat felépítése [cite: 302]
$conn = new mysqli("localhost", "root", "", "nevnapok");
$conn->set_charset("utf8");

// Hónapok tömbje a magyar nevekhez (a te index.php-dből)
$honapok = ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];

$nap_param = $_GET['nap'] ?? null;
$nev_param = $_GET['nev'] ?? null;

// 7. Paraméter hiánya: Útmutató küldése [cite: 218, 219]
if (!$nap_param && !$nev_param) {
    echo json_encode(["minta1" => "/?nap=12-31", "minta2" => "/?nev=Szilveszter"], JSON_UNESCAPED_UNICODE);
    exit;
}

// 4-5. Keresés dátum alapján (a te explode-os logikáddal, de prepare-rel) [cite: 208, 210]
if ($nap_param) {
    // Szétszedjük a paramétert (pl. "4-30") [cite: 210]
    $reszek = explode("-", $nap_param);
    $ho = $reszek[0];
    $nap = $reszek[1];

    // Biztonságos lekérdezés a ho és nap oszlopokra [cite: 304, 312]
    $stmt = $conn->prepare("SELECT ho, nap, nev1, nev2 FROM nevnap WHERE ho = ? AND nap = ?");
    $stmt->bind_param("ii", $ho, $nap); // "ii" jelentése: két integer (egész szám)
} 
// 6. Keresés név alapján [cite: 212, 213]
else if ($nev_param) {
    $stmt = $conn->prepare("SELECT ho, nap, nev1, nev2 FROM nevnap WHERE nev1 = ? OR nev2 = ? LIMIT 1");
    $stmt->bind_param("ss", $nev_param, $nev_param); // "ss" jelentése: két string (szöveg)
}

$stmt->execute();
$result = $stmt->get_result();

// Eredmény feldolgozása [cite: 211, 214, 240]
if ($row = $result->fetch_assoc()) {
    $valasz = [
        // A tömbből vesszük ki a hónap nevét a sorszám alapján
        "datum" => $honapok[$row['ho'] - 1] . " " . $row['nap'] . ".",
        "nevnap1" => $row['nev1']
    ];
    
    // Ha van második névnap, azt is hozzáadjuk [cite: 211, 212]
    if (!empty($row['nev2'])) {
        $valasz["nevnap2"] = $row['nev2'];
    }

    echo json_encode($valasz, JSON_UNESCAPED_UNICODE);
} else {
    // 8. Nincs találat vagy rossz paraméter [cite: 220, 221]
    echo json_encode(["hiba" => "nincs találat"], JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>