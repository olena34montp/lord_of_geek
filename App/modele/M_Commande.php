<?php

class M_Commande {
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
        // $req = "insert into commandes(client_id, created_at) values (':idClient', NOW())";
        // $pdo = AccesDonnees::getPdo();
        // $res = $pdo->prepare($req);
        // //$res = AccesDonnees::exec($req);
        // $res->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        // $res->execute();
        // $res->fetchAll(PDO::FETCH_ASSOC);
        // $idCommande = AccesDonnees::getPdo()->lastInsertId();
        // foreach ($listJeux as $jeu) {
        //     $req = "insert into lignes_commande(commande_id, exemplaire_id) values (':idCommande',':jeu')";
        //     //$res = AccesDonnees::exec($req);
        //     $pdo = AccesDonnees::getPdo(); //? чи треба додавати його ще раз для другого рекету ?
        //     $res = $pdo->prepare($req);
        //     $res->bindParam(':idCommande', $idCommande, PDO::PARAM_INT).
        //     $res->bindParam(':jeu', $jeu, PDO::PARAM_INT);
        //     $res->execute();
        //     $res->fetch(PDO::FETCH_ASSOC);

        //     $req2 = "UPDATE exemplaires SET statut = 'commande' WHERE id = ':jeu';";
        //     $res2 = $pdo->prepare($req2);
        //     $res2->bindParam(':jeu', $jeu, PDO::PARAM_INT);
        //     $res2->execute();
        //     $res2->fetch(PDO::FETCH_ASSOC);
        //     //$res2 = AccesDonnees::exec($req2);
        //}
    }
    public static function afficherCommandes ($idClient) {
        // $req = "select exemplaires.description, exemplaires.prix, categories.nom, exemplaires.etat, exemplaires.statut 
        // from commandes 
        // join client
        // on commandes.client_id = client.id
        // join lignes_commande 
        // ON commandes.id = lignes_commande.commande_id  
        // join exemplaires
        // ON lignes_commande.exemplaire_id = exemplaires.id
        // join categories
        // on exemplaires.categorie_id = categories.id
        // where client.id = '$idClient'";
        //$res = AccesDonnees::query($req);
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "SELECT exemplaires.description, exemplaires.prix, categories.nom, exemplaires.etat, exemplaires.statut, lignes_commande.id AS commande_id
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
    // public static function afficherCommande ($idClient) {
    //     $req = "select distinct commande_id 
    //     from commandes 
    //     join client
    //     on commandes.client_id = client.id
    //     join lignes_commande 
    //     ON commandes.id = lignes_commande.commande_id  
    //     join exemplaires
    //     ON lignes_commande.exemplaire_id = exemplaires.id
    //     join categories
    //     on exemplaires.categorie_id = categories.id
    //     where client.id = '$idClient'";
    //     $res = AccesDonnees::query($req);
    //     $lesCommande = $res->fetchAll(PDO::FETCH_ASSOC);
    //     return $lesCommande;
    // }
    // public static function afficherExemplairesParCommandes ($idCommande) { 
    //     $req = "select exemplaires.description, exemplaires.prix, categories.nom, exemplaires.etat, exemplaires.statut
    //     from commandes 
    //     join client
    //     on commandes.client_id = client.id
    //     join lignes_commande 
    //     ON commandes.id = lignes_commande.commande_id  
    //     join exemplaires
    //     ON lignes_commande.exemplaire_id = exemplaires.id
    //     join categories
    //     on exemplaires.categorie_id = categories.id
    //     where lignes_commande.commande_id = '$idCommande'";
    //     $res = AccesDonnees::query($req);
    //     $lesExemplaires = $res->fetchAll(PDO::FETCH_ASSOC);
    //     return $lesExemplaires;
    // }
}
