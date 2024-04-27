<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Couleur Belgique</title>
</head>
<body>
    <div class="container">
    <?php
        $phrase = $_GET["phrase"];
        $afficher_phrase = $_GET["afficher_phrase"];
        if ($afficher_phrase):
            // split la phrase sur les espaces tout en les conservants dans le tableau résultant
            $mots = preg_split('/(\s+)/', $phrase, -1, PREG_SPLIT_DELIM_CAPTURE);
            $classes = ['noir', 'jaune', 'rouge'];
            $class_index = 0;
            echo "<div class='phrase'>";
            foreach ($mots as $mot):
                // trim sur le mot, comme le mot peut-être un espace, si le mot est un espace il va disparaître à cause du trim,
                // il faut donc l'afficher cette espace
                if (trim($mot) !== ''):
                    $lettres = str_split($mot);
                    foreach ($lettres as $lettre) {
                        echo "<span class='" . $classes[$class_index] . "'>" . $lettre . "</span>";
                        $class_index = ($class_index + 1) % count($classes);
                    }
                else:
                    echo $mot;
                endif;
            endforeach;
            echo "</div>";
        else:
            echo "<div class='phrase'>";
                echo "<p>Il n'y a pas au moins 10 mots</p>";
            echo "</div>";
        endif;

    ?>
        <form method="post" action="traitement.php">
            <label for="phrase">Entrez une phrase d'au moins 10 mots :</label><br>
            <textarea id="phrase" name="phrase" rows="4" cols="50"><?php echo $phrase; ?></textarea><br>
            <input type="submit" value="Valider">
        </form>
    </div>
</body>
</html>


