# Névnapkereső Feladat – Minta feladatsor

Ez a repository a **Budapesti Komplex Szakképzési Centrum Weiss Manfréd Technikum, Szakképző Iskola és Kollégium** által kiadott, *2022-es Asztali és webes szoftverfejlesztés, adatbázis-készítés* minta feladatsor **2. Komplex webes és adatbázis-kezelési feladat (Névnapkereső)** megvalósítását tartalmazza.

## Technológiai verem

* **Felhasznált nyelvek:**
    * PHP
    * HTML
    * CSS
* **Adatbázis:** MariaDB
* **Futtatókörnyezet:** XAMPP

---

## A projekt felépítése és mappaszerkezete

A repository különböző megközelítésekben és komplexitási szinteken mutatja be a feladat megoldását.

### 1. `api` mappa
Itt található a névnapkereső API végpontjainak megvalósítása. Funkcionálisan mindegyik verzió ugyanazt a feladatot látja el, de az építőköveik és a programozási paradigmák eltérnek:
* `aimegoldas.php`: Teljesen objektumorientált (OOP) megvalósítás.
* *A többi fájl*: Procedurális/hagyományos kódstruktúra.

### 2. `bonyolult_nevnapkereso` mappa
* **Kialakítás:** Komplex, részletes CSS dizájn.
* **Adatátvitel:** Az API válaszát az URL-ben (GET paraméterként) továbbítja. Ez a megközelítés bár működőképes, biztonsági és eleganciabeli szempontból nem a legoptimálisabb.

### 3. `kozepes_nevnapkereso` mappa
* **Kialakítás:** Szolidabb, letisztultabb CSS és egyszerűsített űrlap (form).
* **Adatátvitel:** Az API válaszát már nem az URL-be égetve adjuk át, hanem **Session** használatával. Ez egy lényegesen biztonságosabb, zártabb és elegánsabb webfejlesztési megoldás.

### 4. `konnyu_nevnapkereso` mappa
* **Kialakítás:** Nem készült hozzá külön CSS fájl, sem különálló `handler.php` az adatok feldolgozására. Minden logika és megjelenítés közvetlenül az `index.php` fájlban kapott helyet.
* **Adatátvitel:** Nem használ sem Session-t, sem GET paramétereket, kizárólag **POST** kérésekre támaszkodik.
* **Cél:** A feladat abszolválása a lehető legegyszerűbb módon, a legkevesebb kódsor felhasználásával.

### 5. `1_filos_nevnapkereso` mappa
* **Kialakítás:** Ebben a verzióban a névnapkereső API-t már nem mi magunk biztosítjuk lokálisan, hanem egy **külső, harmadik fél által üzemeltetett API-ra** támaszkodunk.
* **Technikai részlet:** Az egyszerűbb `file_get_contents()` függvény helyett **cURL** használatával történik a külső API válaszának lekérése és feldolgozása. Ennek oka, hogy a `file_get_contents()` távoli erőforrások esetén gyakran szerverkonfigurációs korlátokba ütközhet (pl. `allow_url_fopen` tiltása), míg a cURL robusztus és megbízható megoldást nyújt külső kapcsolatok kezelésekor.