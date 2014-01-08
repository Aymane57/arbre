<?php
require_once './dao.php';
require_once './object.class.php';

## Affichage de l'arbre - fonction récursive ##

function getChilds($id_parent) {
    $arrayOfChilds = dao::getChildsByParent($id_parent);
    # On cherche les enfants qui ont pour parent id_parent
    if ($arrayOfChilds) {
        # S'il y en a .. on les parcourt
        echo "<ul>\n";
        foreach ($arrayOfChilds as $child) {
            echo '<li>' . $child->getCode() . "</li>\n";
            getChilds($child->getId()); # Pour chaque enfant on vérifie s'il en a à son tour
            if ($child === end($arrayOfChilds)) {
                echo "</ul>\n";
            }
        }
    }
}

## L'ajout dans la base ##
if (isset($_POST['code']) && trim($_POST['code']) && isset($_POST['parent'])) {
    # On vérifie un minimum (pas de message d'erreur, feignantise)
    dao::addObject($_POST['parent'], $_POST['code']);
}

$objects = dao::getAllObjects(); # Pour la liste déroulante, on récupére tous les objets
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $begin = microtime(true);

        getChilds(-1);
        # On appelle la fonction d'affichage à partir de la racine
        # J'ai préféré -1 à NULL pour éviter IS NULL coté SQL (un if en moins, toujours ça de gagné)

        $time = microtime(true) - $begin;
        ?>

        <form action="index.php" method="POST">
            <label for="code">Code de l'objet à ajouter : </label>
            <input type="text" name="code" id="code">
            <label for="parent">Parent : </label>
            <select name="parent" id="parent">
                <option value="-1">Aucun</option>
                <?php foreach ($objects as $object) : ?>
                    <option value="<?php echo $object->getId() ?>"><?php echo $object->getCode() ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Go </button>
        </form>
        <br />
        <form action="randgen.php" method="POST">
            <label for="count">Nombre d'objets à ajouter aléatoirement : </label>
            <input type="number" name="count" id="count">
            <button type="submit">Générer des objets aléatoires</button>
        </form>
        <br />
        <?php echo "Arbre généré en $time secondes"; ?>
    </body>
</html>
