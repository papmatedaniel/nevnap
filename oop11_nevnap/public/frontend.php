<?php
session_start();

// 1. FELDOLGOZÁS: Csak akkor fut le, ha POST kérés jött
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nev = $_POST["nev"] ?? '';
    $datum = $_POST["nap"] ?? '';

    $apiurl = "http://localhost/oop11_nevnap/public/";
    $param = "";

    if (!empty($nev)){
        $param = "?nev=" . $nev;
    }
    elseif(!empty($datum)){
        $param = "?nap=" . $datum;
    }

    $visszakapottertek = file_get_contents($apiurl . $param);
    
    $_SESSION["valasz"] = json_decode($visszakapottertek, true);

    header("Location: frontend.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
            if (isset($_SESSION["valasz"])){
                $tomb = $_SESSION["valasz"];
                unset($_SESSION['valasz']); //ne felejtsük el az unsetet, miután a sessionbe lévő adatot kimentettük/felhasználtuk.
                if (isset($tomb["minta1"])) {
                    echo "<strong>minta1:</strong> " . htmlspecialchars($tomb["minta1"]);
                    echo "<br>";
                    echo "<strong>minta2:</strong> " . htmlspecialchars($tomb["minta2"]);
                }
                
                elseif (isset($tomb["hiba"])){
                    echo "<strong>hiba:</strong> " . htmlspecialchars($tomb["hiba"]);
                }

                else{
                    echo "<strong>datum:</strong> " . htmlspecialchars($tomb["datum"]);
                    echo "<br>";
                    echo "<strong>nevnap1:</strong> " .  htmlspecialchars($tomb["nev1"]);
                    echo "<br>";
                    echo "<strong>nevnap2:</strong> " . (!empty($tomb["nev2"]) ? htmlspecialchars($tomb["nev2"]) : "nincs");
                }
            }

        ?>
    </div>

</body>
</html>