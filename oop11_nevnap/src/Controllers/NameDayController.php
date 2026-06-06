<?php

namespace App\Controllers;
use App\Models\NameDay;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// require __DIR__ . '/../../vendor/autoload.php';


class NameDayController{

    public static $honapok = ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];

    public function handleRequest(){

        if (!empty($_GET["nev"])) {
            $adat = NameDay::findByName($_GET["nev"]);
            if ($adat != null) {
                return ["datum" => self::$honapok[$adat["ho"]] . " " . $adat["nap"] . ".",
                        "nev1" => $adat["nev1"],
                        "nev2" => $adat["nev2"]];
            }

            return ["hiba" => "nincs találat"];
        }

        if (!empty($_GET["nap"])) {
            if (count(explode("-", $_GET["nap"])) == 2) {
                $datum = explode("-", $_GET["nap"]);
                $honap = $datum[0];
                $nap = $datum[1];
                $adat = NameDay::findByDate($honap, $nap);
                if ($adat != null) {
                    return ["datum" => self::$honapok[$adat["ho"]] . " " . $adat["nap"] . ".",
                            "nev1" => $adat["nev1"],
                            "nev2" => $adat["nev2"]];                
                }

                return ["hiba" => "nincs találat"];
            }
        }
        return NameDay::getDefaults();
    }

}

// $peldany1 = new NameDayController();
// var_dump($peldany1->handleRequest())

?>