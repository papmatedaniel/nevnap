<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nev = $_POST["nev"] ?? '';
    $datum = $_POST["nap"] ?? '';

    $apiurl = "https://infojegyzet.hu/apiminta/nevnapok/";
    $param = "";

    if (!empty($nev)){
        $param = "?nev=" . urlencode($nev);
    }
    elseif(!empty($datum)){
        $param = "?nap=" . urlencode($datum);
    }

    // 1. cURL munkamenet inicializálása
    $ch = curl_init();

    // 2. Beállítások (Opciók) konfigurálása
    curl_setopt($ch, CURLOPT_URL, $apiurl . $param);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Sztringként adja vissza a választ, ne nyomtassa ki azonnal
    
    // Utánozzuk a böngészőt pontos fejlécekkel
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    
    // Időtúllépések beállítása (Ha 5 másodpercig nem válaszol, ne lógjon a végtelenségig a script)
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

    // Opcionális: Ha a távoli szerver HTTP/2-t használ, használja azt a PHP is (sokkal gyorsabb)
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

    // 3. A kérés végrehajtása
    $visszakapottertek = curl_exec($ch);

    // Hibakezelés: Ha a cURL hibára futna (pl. timeout)
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        echo "cURL Hiba: " . $error_msg;
        $tomb = null;
    } else {
        // 4. Sikeres futás esetén adatok feldolgozása
        $tomb = json_decode($visszakapottertek, true);
    }

    // 5. Erőforrás lezárása
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* 1. Alapbeállítás álló tájoláshoz (Mobil) */
        body {
            display: flex;
            flex-direction: column; /* Egymás ALATT */
            margin: 10px;           /* Kisebb margó */
            font-size: 14px;        /* Kisebb betűméret */
        }

        /* 2. Beállítás széles képernyőhöz (Asztali) */
        @media (min-width: 768px) {
            body {
                flex-direction: row; /* Egymás MELLETT */
                margin: 40px;        /* Nagyobb margó */
                font-size: 18px;     /* Nagyobb betűméret */
                gap: 30px;           /* Csak hogy ne ragadjon össze a form és az eredmény */
            }
        }
    </style>
</head>
<body>

    <form action="" method="post">
        <label for="nev">Add meg a nevet:</label>
        <input type="text" name="nev" id="nev" placeholder="nev">
        <br>
        <label for="nap">Add meg a dátumot:</label>
        <input type="text" name="nap" id="nap" placeholder="nap">
        <br>
        <input type="submit" value="Leadás">
    </form>

    <div id="eredmeny">
        <?php
            // 2. MEGJELENÍTÉS: Csak akkor nézzük meg, ha a $tomb változó létezik
            if (isset($tomb)){

                if (isset($tomb["hiba"])) {
                    echo "<strong>hiba:</strong> " . $tomb["hiba"];
                }
                elseif ($tomb["nevnap"] == null) {
                    echo "<strong>eredmény:</strong> Nincs találat.";
                }
                else {
                    // Kivesszük a [0] indexű elemet a nevnap tömbből
                    $adat = $tomb["nevnap"][0];

                    echo "<strong>datum:</strong> " . $adat["datum"];
                    echo "<br>";
                    echo "<strong>nevnap1:</strong> " . $adat["nevnap1"];
                    echo "<br>";
                    echo "<strong>nevnap2:</strong> " . (!empty($adat["nevnap2"]) ? $adat["nevnap2"] : "nincs");
                }
            }
        ?>
    </div>

</body>
</html>