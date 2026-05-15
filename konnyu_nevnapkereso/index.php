<?php
// 1. FELDOLGOZÁS: Csak akkor fut le, ha POST kérés jött
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nev = $_POST["nev"] ?? '';
    $datum = $_POST["datum"] ?? '';

    $apiurl = "http://localhost/konnyu_nevnapkereso/api/";
    $param = "";

    if (!empty($nev)){
        $param = "?nev=" . $nev;
    }
    elseif(!empty($datum)){
        $param = "?datum=" . $datum;
    }

    $visszakapottertek = file_get_contents($apiurl . $param);
    
    // Elmentjük egy SIMA változóba. Mivel nincs átirányítás, a lentebbi HTML látni fogja!
    $tomb = json_decode($visszakapottertek, true);
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
        <label for="datum">Add meg a dátumot:</label>
        <input type="text" name="datum" id="datum" placeholder="datum">
        <br>
        <input type="submit" value="Leadás">
    </form>

    <div id="eredmeny">
        <?php
            // 2. MEGJELENÍTÉS: Csak akkor nézzük meg, ha a $tomb változó létezik (tehát volt POST hívás)
            if (isset($tomb)){

                if (isset($tomb["minta1"])) {
                    echo "<strong>minta1:</strong> " . $tomb["minta1"];
                    echo "<br>";
                    echo "<strong>minta2:</strong> " . $tomb["minta2"];
                }
                elseif (isset($tomb["hiba"])){
                    echo "<strong>hiba:</strong> " . $tomb["hiba"];
                }
                else{
                    echo "<strong>datum:</strong> " . $tomb["datum"];
                    echo "<br>";
                    echo "<strong>nevnap1:</strong> " .  $tomb["nevnap1"];
                    echo "<br>";
                    echo "<strong>nevnap2:</strong> " . (!empty($tomb["nevnap2"]) ? $tomb["nevnap2"] : "nincs");
                }
            }
        ?>
    </div>

</body>
</html>