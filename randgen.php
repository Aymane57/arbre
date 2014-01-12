<?php

require_once './dao.php';
require_once './object.class.php';

function isDataValid() {
    if (!isset($_POST['count'])) {
        return FALSE;
    }
    if (!trim(($_POST['count']))) {
        return FALSE;
    }
    if (!is_numeric(($_POST['count']))) {
        return FALSE;
    }
    if ($_POST['count'] != (int) ($_POST['count'])) {
        return FALSE;
    }
    if ((int) ($_POST['count']) <= 0) {
        return FALSE;
    }
    if ((int) ($_POST['count']) > 100) {
        return FALSE;
    }
    return TRUE;
}

if (isDataValid()) {

    for ($i = 0; $i < (int) $_POST['count']; $i++) {
        $letters = ('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $code = substr(str_shuffle($letters), 0, rand(3, 8));
        $arrayOfAllIds = dao::getAllIds();

        if (!$arrayOfAllIds) {
            $id_parent = -1;
        } else {
            do {
                $id_parent = $arrayOfAllIds[rand(0, count($arrayOfAllIds) - 1)][0];
                # On génére un parent parmi ceux qui sont disponibles
            } while (!dao::idExist($id_parent));

            if (rand(1, 20) == 1) {
                # a peu près 5% de chance que l'objet soit à la racine
                $id_parent = -1;
            }
        }

        $arrayOfAllIds[] = $id_parent;
        # On ajout celui qu'on vient de générer dans le tableau d'éventuel parents
        # Ca évite de le rechercher dans la base

        dao::addObject($id_parent, $code);
        # On ajout à la base
    }
}

header("Location: index.php");
?>

