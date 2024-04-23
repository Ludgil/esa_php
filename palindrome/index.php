<?php

$mot = readline("Entrer un mot : ");
// $count = intdiv(strlen($mot), 2);
// $palindrome = false;
// for ($i=0; $i < $count ; $i++) { 
//     if ($mot[$i] != $mot[strlen($mot) - 1 - $i]){
//         $palindrome = false;
//     }else{
//         $palindrome = true;
//     }
// }

// if ($palindrome){
//     echo "Le mot ". $mot ." est un palindrome \n";
// }else{
//     echo "Le mot ". $mot ." n'est pas un palindrome \n";
// }

$reverse = strrev($mot);

if ($mot === $reverse){
    echo "Le mot ". $mot ." est un palindrome \n";
}else{
    echo "Le mot ". $mot ." n'est pas un palindrome \n";
}


