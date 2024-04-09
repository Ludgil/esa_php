<?php
echo '<table style="border:1px solid black; border-collapse: collapse;">';
for($i=0;$i<8;$i++){
    echo '<tr>';
    for($j=0;$j<8;$j++){
        if($i % 2){
            if(!($j % 2)){
                echo '<td style="background-color:grey; padding:20px; margin:0"></td>';
            }
            else{
                echo '<td style="background-color:white; padding:20px; margin:0"></td>';
            }
        }else{
            if(($j % 2)){
                echo '<td style="background-color:grey; padding:20px; margin:0"></td>';
            }
            else{
                echo '<td style="background-color:white; padding:20px; margin:0"></td>';
            }
        }
        
    }
    echo '</tr>';
}
echo '</table>';
