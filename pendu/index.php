<?php

include_once("dessin.php");

$liste_mots = file('.'. DIRECTORY_SEPARATOR .'mots.txt');

function demande_lettre():string{
    do{
        $demande_lettre = readline('Veuillez entrer une lettre : ');
    }while(!ctype_alpha($demande_lettre));
    return strtoupper($demande_lettre);
}

function cacher_le_mot($mot):string{
    $mot_cacher = "";
    foreach(str_split($mot) as $lettre){
        $mot_cacher .= "_";
    }
    return $mot_cacher;
}

function afficher_lettres_utilisées($liste){
    print("Lettres déjà utilisées : ".implode(", ", $liste) . "\n");
}

function pendu(){
    global $titre;
    global $liste_mots;
    $taille_liste = count($liste_mots) - 1;
    $mot_a_trouver = trim($liste_mots[rand(0, $taille_liste)]);
    $mot_cacher = cacher_le_mot($mot_a_trouver);
    $essai = 8;
    $gagner = false;
    $lettre_utilisee = [];
    $lettre = "";
    print($titre);
    do{
        $trouver = false;
        print(dessinPendu($essai) . "\n");
        print("nombre d'éssai restant : " . $essai ."\n");
        print($mot_cacher . "\n" . "\n");
        if(!empty($lettre_utilisee)){
            afficher_lettres_utilisées($lettre_utilisee);
        }
        
        do{
            $lettre = demande_lettre();  
        } while(in_array($lettre, $lettre_utilisee));
        
        foreach(str_split($mot_a_trouver) as $index => $lettre_a_trouver){
            if($lettre == $lettre_a_trouver){
                $mot_cacher[$index] = $lettre;
                $trouver = true;
            }
        }
        if($trouver == false){
            $essai--;
        }
        array_push($lettre_utilisee, $lettre);
        if(strcasecmp($mot_a_trouver, $mot_cacher) == 0){
            $gagner = true;
            print($mot_cacher . "\n");
            print("GAGNER \n");
        }
        if($essai == 0){
            print("PERDU le mot était : ".$mot_a_trouver."\n");
        }
    }while($essai > 0 && !$gagner);
}

pendu();

