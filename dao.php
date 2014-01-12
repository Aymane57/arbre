<?php

require_once './connect.php';

class dao {

    static function getChildsByParent($id_parent) {

        $db = connect::getInstance();
        $query = $db->prepare('SELECT *
            FROM objects
            WHERE id_parent = :id_parent');

        $query->bindValue(':id_parent', $id_parent);
        $query->execute();

        $childs = NULL;
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
            $childs[$key] = new Object($value);
        }

        $query->closeCursor();
        $db = NULL;

        return $childs;
    }

    static function getAllObjects() {
        $db = connect::getInstance();
        $query = $db->prepare('SELECT *
            FROM objects');

        $query->execute();

        $objects = NULL;
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
            $objects[$key] = new Object($value);
        }

        $query->closeCursor();
        $db = NULL;

        return $objects;
    }

    static function getAllIds() {

        $db = connect::getInstance();
        $query = $db->prepare('SELECT id
            FROM objects');

        $query->execute();

        $arrayOfIds = $query->fetchAll(PDO::FETCH_NUM);

        $query->closeCursor();
        $db = NULL;

        return $arrayOfIds;
    }

    static function addObject($id_parent, $code) {

        $db = connect::getInstance();
        $query = $db->prepare('INSERT INTO objects
            SET id_parent = :id_parent,
                code = :code');

        $query->bindValue(':id_parent', $id_parent);
        $query->bindValue(':code', $code);

        $query->execute();

        $query->closeCursor();
        $db = NULL;
    }

    static function getMaxId() {
        $db = connect::getInstance();
        $query = $db->prepare('SELECT MAX(id) FROM objects');

        $query->execute();

        $max = $query->fetchColumn(0);

        $query->closeCursor();
        $db = NULL;

        return $max;
    }

    static function idExist($id) {
        $db = connect::getInstance();
        $query = $db->prepare('SELECT id '
                . 'FROM objects '
                . 'WHERE id = :id');

        $query->bindValue(':id', $id);
        $query->execute();

        $exist = FALSE;
        if ($query->fetch()) {
            $exist = TRUE;
        }

        return $exist;
    }

}

?>
