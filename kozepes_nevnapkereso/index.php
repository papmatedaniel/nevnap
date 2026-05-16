<?php 
session_start();
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
    <form action="handler.php" method="post">

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
                // var_dump($tomb);
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
                    echo "<strong>nevnap1:</strong> " .  htmlspecialchars($tomb["nevnap1"]);
                    echo "<br>";
                    echo "<strong>nevnap2:</strong> " . (!empty($tomb["nevnap2"]) ? htmlspecialchars($tomb["nevnap2"]) : "nincs");
                }
            }

        ?>
    </div>

</body>
</html>