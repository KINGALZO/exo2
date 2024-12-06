<?php
// Fonctions Access aux données
function selectClients(): array {
    return [
        [
            "nom" => "Wane",
            "prenom" => "Baila",
            "telephone" => "777661010",
            "adresse" => "FO",
            "dettes" => [] // Liste vide pour les dettes
        ],
        [
            "nom" => "Wane1",
            "prenom" => "Baila1",
            "telephone" => "777661011",
            "adresse" => "FO1",
            "dettes" => [] // Liste vide pour les dettes
        ]
    ];
}

function selectClientByTel(array $clients, string $tel): array|null {
    foreach ($clients as $client) {
        if ($client["telephone"] == $tel) {
            return $client;
        }
    }
    return null;
}

function insertClient(array &$tabClients, $client): void {
    $tabClients[] = $client;
}

// Génération automatique d'une référence pour une dette
function genererReference(): string {
    return "DET-" . uniqid();
}

// Génération automatique de la date actuelle
function genererDate(): string {
    return date("Y-m-d H:i:s");
}

// Ajouter une dette à un client
function ajouterDette(array &$client, float $montant): void {
    $client["dettes"][] = [
        "reference" => genererReference(),
        "montant" => $montant,
        "date" => genererDate(),
        "montant_verse" => 0
    ];
}

// Lister les dettes d'un client
function listerDettes(array $client): void {
    if (empty($client["dettes"])) {
        echo "Aucune dette pour ce client.\n";
        return;
    }

    foreach ($client["dettes"] as $dette) {
        echo "\n-----------------------------------------\n";
        echo "Référence : " . $dette["reference"] . "\n";
        echo "Montant : " . $dette["montant"] . "\n";
        echo "Montant versé : " . $dette["montant_verse"] . "\n";
        echo "Date : " . $dette["date"] . "\n";
    }
}

// Fonction pour payer une dette
function payerDette(array &$client, string $reference, float $montant): void {
    foreach ($client["dettes"] as &$dette) {
        if ($dette["reference"] === $reference) {
            $reste = $dette["montant"] - $dette["montant_verse"];
            if ($montant > $reste) {
                echo "Montant trop élevé. Le reste à payer est : $reste\n";
                return;
            }
            $dette["montant_verse"] += $montant;
            echo "Paiement effectué. Montant versé : $montant\n";
            return;
        }
    }
    echo "Référence de la dette introuvable.\n";
}

// Fonctions Services ou Use Case ou Métier
function enregistrerClient(array &$tabClients, array $client): bool {
    $result = selectClientByTel($tabClients, $client["telephone"]);
    if ($result == null) {
        insertClient($tabClients, $client);
        return true;
    }
    return false;
}

function saisieDette(): float {
    return (float) readline("Entrez le montant de la dette : ");
}

function chercherClientParTel(array &$clients): array|null {
    $telephone = readline("Entrez le téléphone du client : ");
    return selectClientByTel($clients, $telephone);
}

// Fonction principale
function principal() {
    $clients = selectClients();
    do {
        echo "
         1. Ajouter client \n
         2. Lister les clients\n
         3. Ajouter une dette\n
         4. Lister les dettes d'un client\n
         5. Payer une dette\n
         6. Quitter\n";
        $choix = (int) readline("Faites votre choix : ");

        switch ($choix) {
            case 1:
                $client = saisieClient($clients);
                if (enregistrerClient($clients, $client)) {
                    echo "Client enregistré avec succès.\n";
                } else {
                    echo "Le numéro de téléphone existe déjà.\n";
                }
                break;

            case 2:
                afficheClient($clients);
                break;

            case 3:
                $client = chercherClientParTel($clients);
                if ($client) {
                    $montant = saisieDette();
                    ajouterDette($client, $montant);
                    echo "Dette ajoutée avec succès.\n";
                } else {
                    echo "Client introuvable.\n";
                }
                break;

            case 4:
                $client = chercherClientParTel($clients);
                if ($client) {
                    listerDettes($client);
                } else {
                    echo "Client introuvable.\n";
                }
                break;

            case 5:
                $client = chercherClientParTel($clients);
                if ($client) {
                    $reference = readline("Entrez la référence de la dette : ");
                    $montant = (float) readline("Entrez le montant à payer : ");
                    payerDette($client, $reference, $montant);
                } else {
                    echo "Client introuvable.\n";
                }
                break;

            case 6:
                echo "Au revoir !\n";
                break;

            default:
                echo "Veuillez faire un choix valide.\n";
                break;
        }
    } while ($choix != 6);
}
principal();
