<?php

namespace App\Models;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $db_name = "nevnapok"; // Majd ezt az adatbázist hozzuk létre XAMPP-ban
    private $username = "root";
    private $password = "";
    private $conn;

    // A konstruktor azonnal megpróbál csatlakozni, amikor leírjuk, hogy: new Database()
    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            // Ha hiba van, a PDO dobjon egy "Exception"-t (kiabáljon)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die(json_encode(["error" => "Adatbázis hiba: " . $e->getMessage()]));
        }
    }

    // Ez az univerzális, biztonságos lekérdezőnk (A "Pajzs")
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        
        // Ha SELECT-et futtattunk, visszaadjuk a sorokat tömbként
        if (str_contains(strtoupper($sql), 'SELECT')) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // Ha INSERT/UPDATE volt, akkor true-val térünk vissza (sikeres volt)
        return true;
    }
}