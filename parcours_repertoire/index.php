<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Parcours de répertoire</title>
</head>
<body>
    <div class="container">
        <ul class="liste">
        <?php 
            $pointeur = opendir($_SERVER["DOCUMENT_ROOT"]) or die('Erreur de listage : le répertoire n existe pas');
            while($element = readdir($pointeur)){
                if ($element != '.' && $element != '..'){
                    if(is_file($element)){
                        echo '<li class="file">File : ' . $element .'</li>';
                    }
                    else{
                        echo '<li class="folder">Folder : ' . $element .'</li>';
                    }
                }
            }
            closedir($pointeur);
        ?>
        </ul>
    </div>
</body>
</html>


