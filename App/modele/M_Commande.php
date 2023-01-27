<?php

class M_Commande {
    public static function creerCommande($idClient, $listJeux) {
        $req = "insert into commandes(client_id, created_at) values ('$idClient', NOW())";
        $res = AccesDonnees::exec($req);
        $idCommande = AccesDonnees::getPdo()->lastInsertId();
        foreach ($listJeux as $jeu) {
            $req = "insert into lignes_commande(commande_id, exemplaire_id) values ('$idCommande','$jeu')";
            $res = AccesDonnees::exec($req);
            $req2 = "UPDATE exemplaires SET statut = 'commande' WHERE id = '$jeu';";
            $res2 = AccesDonnees::exec($req2);
        }
    }
    public static function afficherCommandes ($idClient) { //DISTINCT commandes.id
        $req = "select exemplaires.description, exemplaires.prix, categories.nom, exemplaires.etat, exemplaires.statut 
        from commandes 
        join client
        on commandes.client_id = client.id
        join lignes_commande 
        ON commandes.id = lignes_commande.commande_id  
        join exemplaires
        ON lignes_commande.exemplaire_id = exemplaires.id
        join categories
        on exemplaires.categorie_id = categories.id
        where client.id = '$idClient'";
        $res = AccesDonnees::query($req);
        $lesCommandes = $res->fetchAll(PDO::FETCH_ASSOC);
        return $lesCommandes;
    }
}
