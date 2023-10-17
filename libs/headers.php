<?php

global $yhendus;

$location_add = "";
if (isset($_REQUEST["container"])) {
    $location_add .= (strlen($location_add) ? "&" : "?") . "container=" . $_REQUEST["container"];
}

if (isset($_REQUEST["page"])) {
    $location_add .= (strlen($location_add) ? "&" : "?") . "page=" . $_REQUEST["page"];
}

$cur_ = $_SERVER['PHP_SELF'] . $location_add;

if (isset($_REQUEST["masslisamine"])) {
    if (!empty($_REQUEST["valjumismass"]) && !empty($_REQUEST["auto_id"]) && !preg_match("#[A-z]#", $_REQUEST["valjumismass"])) {
        $kask = $yhendus->prepare("UPDATE koormad SET lahkumismass=? WHERE id=?");
        $kask->bind_param("ii", $_REQUEST["valjumismass"], $_REQUEST["auto_id"]);
        $kask->execute();
    }
}

if (isset($_REQUEST["autolisamine"])) {
    if (!empty($_REQUEST["autonr"]) && !empty($_REQUEST["sisenemismass"]) && !preg_match("#[A-z]#", $_REQUEST["sisenemismass"])) {
        $kask = $yhendus->prepare("INSERT INTO koormad (autonr, sisenemismass, lahkumismass) VALUES (?, ?, 0)");
        $kask->bind_param("si", $_REQUEST["autonr"], $_REQUEST["sisenemismass"]);
        $kask->execute();
    }
}
