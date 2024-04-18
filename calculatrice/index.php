<?php

function calculatrice(){
    $n1 = readline("Entrer un nombre : ");
    if(!is_numeric($n1)){
        echo "Le nombre doit être un chiffre \n";
        calculatrice();
    } 
    $operateur = readline("Entrer l'opérateur : ");
    if($operateur != "-" and $operateur != "+" and $operateur != "*" and $operateur != "%" and $operateur != "/" ){
        echo "L'opérateur n'est pas correcte \n";
        calculatrice();
    }
    $n2 = readline("Entrer le 2ieme nombre : ");
    if(!is_numeric($n2)){
        echo "Le nombre doit être un chiffre \n";
        calculatrice();
    }

    if(($n1 == 0 or $n2 == 0) and $operateur == "/"){
        echo "ERROR DIVISION 0 \n";
        calculatrice();
    }

    $result="";
    switch($operateur){
        case "+":
            $result = $n1 + $n2;
            break;
        case "-":
            $result = $n1 - $n2;
            break;
        case "*":
            $result = $n1 * $n2;
            break;
        case "/":
            $result = $n1 / $n2;
            break;
        case "%":
            $result = $n1 % $n2;
            break;
    }
    echo "Résultat ".$n1 ." ". $operateur . " ". $n2 ." = " . $result . "\n";

    calculatrice();
}

calculatrice();