<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Névnapkereső Projekt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="search-section">
            <h1>Névnapkereső</h1>
            <form action="handler.php" method="POST">
                <div class="input-group">
                    <label for="nap">Dátum (hónap-nap):</label>
                    <input type="text" name="nap" id="nap" placeholder="pl. 04-30">
                </div>
                
                <div class="divider">VAGY</div>
                
                <div class="input-group">
                    <label for="nev">Keresztnév:</label>
                    <input type="text" name="nev" id="nev" placeholder="pl. Katalin">
                </div>
                
                <button type="submit">Keresés indítása</button>
            </form>
        </section>

        <section class="result-section">
            <h2>Eredmény</h2>
            <div id="result-display">
                <?php 
                if (isset($_GET['data'])) {
                    $res = json_decode(urldecode($_GET['data']), true);
                    
                    if (isset($res['hiba'])) {
                        echo "<p class='error'>Sajnos " . htmlspecialchars($res['hiba']) . "</p>"; //[cite: 215, 310]
                    } elseif (isset($res['mintal'])) {
                        // 7. feladat: Útmutatás, ha nincs paraméter [cite: 212, 213, 308]
                        echo "<p class='info'>Használat: adjon meg egy nevet (pl. " . htmlspecialchars($res['minta2']) . ") vagy dátumot!</p>";
                    } else {
                        echo "<div class='success'>";
                        
                        // Ha a felhasználó nevet írt be a formba, akkor a dátum a lényeg
                        if (!empty($_POST['nev'])) { 
                            echo "<p>A keresett név dátuma: <strong>" . htmlspecialchars($res['datum']) . "</strong></p>"; //[cite: 237, 346]
                        } 
                        // Ha dátumot írt be, akkor a nevek a lényegesek
                        else {
                            echo "<p>Ezen a napon (<strong>" . htmlspecialchars($res['datum']) . "</strong>) ünneplik:</p>"; //[cite: 236, 344]
                            echo "<h3>" . htmlspecialchars($res['nevnap1']);
                            if (isset($res['nevnap2'])) echo ", " . htmlspecialchars($res['nevnap2']);
                            echo "</h3>";
                        }
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>