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
            var_dump(AccesDonnees::getPdo()->errorInfo());
        }
    }
}
