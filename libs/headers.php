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

    if (isset($_REQUEST["page"]) && $_REQUEST["page"] == "main") {
        if (isset($_REQUEST["masslisamine"])) {




        }

        if (isset($_REQUEST["autolisamine"])) {
            if (!empty($_REQUEST["autonr"]) && !empty($_REQUEST["sisenemismass"])) {
                $kask = $yhendus->prepare("INSERT INTO kaubad (autonr, kaubagrupi_id) VALUES (?, ?)");
                $kask->bind_param("si", $_REQUEST["autonr"], $_REQUEST["sisenemismass"]);
                $kask->execute();
            }
        }
    }