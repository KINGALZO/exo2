<?php
define("N", 100);
$tab = array_fill(0, N, null); 
$pos = 0;  
$taille = 0;  

// Fonction pour ajouter une valeur au tableau
function ajouterValeur(&$tab, &$pos, $val, &$taille) {
    if ($pos < N) {
        $tab[$pos] = $val;
        $taille = $pos + 1; 
        $pos++;
    } else {
        echo "Le tableau est plein, vous ne pouvez plus ajouter.\n";
    }
}

// Fonction pour afficher le contenu du tableau
function AfficheTab($tab, $taille) {
    for ($i = 0; $i < $taille; $i++) {
        echo $tab[$i] . "\n"; 
    }
}
function InverseTab(&$t, $taille) {
    $temp =0; 
    $i = 0;
    for ($i = 0; $i < intval($taille / 2); $i++) {
        $temp = $t[$i]; 
        $t[$i] = $t[$taille - $i - 1]; 
        $t[$taille - $i - 1] = $temp;
    }
}


// Fonction pour afficher le menu principal et obtenir le choix de l'utilisateur
function MenuPrincipal() {
    echo "1 - Saisir Tableau\n";
    echo "2 - Tableau non trié\n";
    echo "3 - Tableau trié\n";
    echo "4 - Quitter\n";
    echo "Faites votre choix entre 1, 2, 3, 4: ";
    $choix = intval(trim(fgets(STDIN)));
    return $choix;
}

// Fonction pour afficher le menu du tableau non trié et obtenir le choix de l'utilisateur
function MenuTableauNonTrie() {
    echo "1 - Afficher Tableau\n";
    echo "2 - Inverser Tableau\n";
    echo "3 - Rechercher une valeur dans le tableau\n";
    echo "4 - Insérer une valeur à une position donnée\n";
    echo "5 - Supprimer une ou des valeurs\n";
    echo "6 - Retour\n";
    echo "7 - Quitter\n";
    echo "Faites votre choix entre 1 et 7: ";
    $choix = intval(trim(fgets(STDIN)));
    return $choix;
}
//rechercher valeurs
function rechercheValeur($tab, $taille, $valeur) {
    for ($i = 0; $i < $taille; $i++) { 
        if ($tab[$i] === $valeur) {  
            return $i + 1;
        }
    }
    return 0; 
}
//supprimer valeurs
function supprimerValeur(&$tab, &$taille, $valeur) {
    // Recherche de la position de la valeur dans le tableau
    $pos = rechercheValeur($tab, $taille, $valeur); 
    
    if ($pos != 0) { 
        if ($pos == $taille) {
            $taille--; 
        } else {
            for ($i = $pos - 1; $i < $taille - 1; $i++) {
                $tab[$i] = $tab[$i + 1];
            }
            $taille--; 
        }
        echo "La valeur $valeur a été supprimée.\n";
    } else {
        echo "La valeur $valeur n'est pas dans le tableau.\n";
    }
}
//ajoutvaleurs
function ajoutValeur(&$tab, &$taille, $pos, $val) {
    // Vérification si le tableau est plein
    if ($taille >= N) {
        echo "Le tableau est plein, vous ne pouvez plus insérer de valeur.\n";
    } else {
        // Recherche si la valeur est déjà présente dans le tableau
        $posi = rechercheValeur($tab, $taille, $val);
        
        // Si la valeur n'est pas trouvée, on l'ajoute à la position donnée
        if ($posi == 0) {
            // Si la position est valide, on décale les éléments et insère la nouvelle valeur
            for ($i = $taille; $i >= $pos; $i--) {
                $tab[$i] = $tab[$i - 1]; // Décaler les éléments à droite
            }
            $tab[$pos] = $val; // Insérer la nouvelle valeur
            $taille++; // Augmenter la taille du tableau
            echo "La valeur $val a été ajoutée à la position $pos.\n";
        } else {
            echo "La valeur $val est déjà présente dans le tableau à la position $posi.\n";
        }
    }
}

//gerermenue
function gererMenuTableauNonTrie(&$tab, &$taille) {
    do {
        $choisir = MenuTableauNonTrie();

        switch ($choisir) {
            case 1:
                AfficheTab($tab, $taille);
                break;

            case 2:
                InverseTab($tab, $taille);
                echo "Tableau inversé : ";
                AfficheTab($tab, $taille);
                break;

            case 3:
                echo "Entrez la valeur à rechercher : ";
                $val = intval(trim(fgets(STDIN)));
                $pos = RechercheValeur($tab, $taille, $val);
                if ($pos !== -1) {
                    echo "La valeur $val se trouve à la position " . ($pos + 1) . ".\n";
                } else {
                    echo "La valeur $val n'est pas présente dans le tableau.\n";
                }
                break;

            case 4:
                if ($taille < N) {
                    echo "Entrez la position d'insertion (1 à " . ($taille + 1) . ") : ";
                    $pos = intval(trim(fgets(STDIN))) - 1;
                    echo "Entrez la valeur à insérer : ";
                    $val = intval(trim(fgets(STDIN)));
                    ajoutValeur($tab, $taille, $pos, $val);
                    echo "Valeur insérée.\n";
                } else {
                    echo "Le tableau est plein, impossible d'ajouter une valeur.\n";
                }
                break;

            case 5:
                echo "Entrez la valeur à supprimer : ";
                $val = intval(trim(fgets(STDIN)));
                supprimerValeur($tab, $taille, $val);
                break;

            case 6:
                return;

            case 7:
                $rep = "oui";
do {
    $choisir = MenuPrincipal();

    if ($choisir == 1) {
        do {
            echo "Saisir la valeur à ajouter: ";
            $val = intval(trim(fgets(STDIN)));
            ajouterValeur($tab, $pos, $val, $taille);
            echo "Voulez-vous continuer (oui/non) ? ";
            $rep = trim(fgets(STDIN));
        } while ($rep == "oui");
    } elseif ($choisir == 2) {
        gererMenuTableauNonTrie($tab, $taille);
    } elseif ($choisir == 3) {
        // Gestion du tableau trié (non implémenté ici)
    } elseif ($choisir != 4) {
        echo "Choix invalide. Veuillez faire un choix entre 1 et 4.\n";
    }

} while ($choisir != 4);

            default:
                echo "Choix invalide. Veuillez faire un choix entre 1 et 7.\n";
        }
    } while (true);
}


// Programme principal
$rep = "oui";
do {
    $choisir = MenuPrincipal();

    if ($choisir == 1) {
        do {
            echo "Saisir la valeur à ajouter: ";
            $val = intval(trim(fgets(STDIN)));
            ajouterValeur($tab, $pos, $val, $taille);
            echo "Voulez-vous continuer (oui/non) ? ";
            $rep = trim(fgets(STDIN));
        } while ($rep == "oui");
    } elseif ($choisir == 2) {
        gererMenuTableauNonTrie($tab, $taille);
    } elseif ($choisir == 3) {
        // Gestion du tableau trié (non implémenté ici)
    } elseif ($choisir != 4) {
        echo "Choix invalide. Veuillez faire un choix entre 1 et 4.\n";
    }

} while ($choisir != 4);
?>