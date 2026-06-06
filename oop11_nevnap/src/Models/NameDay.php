<?php
namespace App\Models;
use App\Models\Database;


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// require __DIR__ . '/../../vendor/autoload.php';

class NameDay{

    private static function getDB(){
        return new Database();
    }

    public static function findByName($nev){
        $sql = "SELECT ho, nap, nev1, nev2 FROM nevnap WHERE nev1 = ? OR nev2 = ? LIMIT 1";
        $lekeredezes = self::getDB()->query($sql, [$nev, $nev]);

        if (count($lekeredezes) != 0) {
            return $lekeredezes[0];
        }
        return null;
    }

    public static function findByDate($honap, $nap){
        $sql = "SELECT ho, nap, nev1, nev2 FROM nevnap WHERE ho = ? AND nap = ?";
        $lekerdezes = self::getDB()->query($sql, [$honap, $nap]);

        if (count($lekerdezes) != 0) {
            return $lekerdezes[0];
        }
        return null;
    }

    public static function getDefaults(){
        return ["minta1" => "minta1", "minta2" => "minta2"];
    }

}

// echo "HELO";
// var_dump(NameDay::findByName("Mátéé"));
// var_dump(NameDay::findByName("Máté"));
// var_dump(NameDay::findByDate(2, 2));
// var_dump(NameDay::getDefaults());



?>