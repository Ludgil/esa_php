<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Damier</title>
</head>
<body>
    <div class="container">
    <?php
    echo '<table class="damier">';
    for($i=0;$i<8;$i++){
        echo '<tr>';
        for($j=0;$j<8;$j++){
            if($i % 2){
                if(!($j % 2)){
                    echo '<td class="tile color1"></td>';
                }
                else{
                    echo '<td class="tile color2"></td>';
                }
            }else{
                if(($j % 2)){
                    echo '<td class="tile color1"></td>';
                }
                else{
                    echo '<td class="tile color2"></td>';
                }
            }
            
        }
        echo '</tr>';
    }
    echo '</table>';
    ?>
    </div>
</body>
</html>


