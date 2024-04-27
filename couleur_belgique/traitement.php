<?php
$phrase = "";
$afficher_phrase = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phrase = $_POST["phrase"];
    if (str_word_count($phrase) >= 10) {
        $afficher_phrase = true;
    } 
}

header("Location: index.php?phrase=" . urlencode($phrase)."&afficher_phrase=".urlencode($afficher_phrase));
exit();