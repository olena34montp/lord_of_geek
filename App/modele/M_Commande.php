<?php

class M_Commande {
    /**
     * Ajoute les informations dans la table commande et lignes_commande
     *
     * @param int $idClient
     * @param array $listJeux 
     */
    public static function creerCommande($idClient, $listJeux) {
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "INSERT INTO commandes(client_id, created_at) 
            VALUES (:idClient, NOW())");
        $stmt->bindParam(":idClient", $idClient, PDO::PARAM_INT);
        $stmt->execute();

        $idCommande = AccesDonnees::getPdo()->lastInsertId();

        foreach ($listJeux as $jeu) {
            $pdo = AccesDonnees::getPdo();
            $stmt = $pdo->prepare(
                "INSERT INTO lignes_commande(commande_id, exemplaire_id) 
                VALUES (:idCommande, :jeu)");
            $stmt->bindParam(":idCommande", $idCommande, PDO::PARAM_INT);
            $stmt->bindParam(":jeu", $jeu, PDO::PARAM_INT);
            $stmt->execute();

            $res = $pdo->prepare(
                "UPDATE exemplaires 
                SET statut = 'commande' 
                WHERE id = :jeu;");
            $res->bindParam(':jeu', $jeu, PDO::PARAM_INT);
            $res->execute();
        }

    }
    /**
     * Affiche les commandes du client
     *
     * @param int $idClient
     * @return array
     */
    public static function afficherCommandes ($idClient) {
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "SELECT exemplaires.description, exemplaires.prix, categories.nom, exemplaires.etat, exemplaires.statut, lignes_commande.commande_id
            FROM commandes 
            JOIN client
            ON commandes.client_id = client.id
            JOIN lignes_commande 
            ON commandes.id = lignes_commande.commande_id  
            JOIN exemplaires
            ON lignes_commande.exemplaire_id = exemplaires.id
            JOIN categories
            ON exemplaires.categorie_id = categories.id
            WHERE client.id = :idClient;");
        $stmt->bindParam(":idClient", $idClient, PDO::PARAM_INT);
        $stmt->execute();
        $lesCommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lesCommandes;
    }
}
