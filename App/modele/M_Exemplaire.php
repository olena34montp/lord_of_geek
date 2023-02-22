<?php

/**
 * Requetes sur les exemplaires  de jeux videos
 *
 * @author Loic LOG
 */
class M_Exemplaire {

    /**
     * Retourne sous forme d'un tableau associatif tous les jeux de la
     * catégorie passée en argument
     *
     * @param $idCategorie
     * @return un tableau associatif
     */
    public static function trouveLesJeuxDeCategorie($idCategorie) {
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "SELECT * 
            FROM exemplaires 
            WHERE categorie_id = :idCategorie AND statut = 'disponible'");
        $stmt->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
        $stmt->execute();
        $lesLignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lesLignes;
    }

    /**
     * Retourne les jeux concernés par le tableau des idProduits passée en argument
     *
     * @param $desIdJeux tableau d'idProduits
     * @return un tableau associatif
     */
    public static function trouveLesJeuxDuTableau($desIdJeux) {
        $nbProduits = count($desIdJeux);
        $lesProduits = array();
        if ($nbProduits != 0) {
            foreach ($desIdJeux as $unIdProduit) {
                $pdo = AccesDonnees::getPdo();
                $stmt = $pdo->prepare(
                    "SELECT * 
                    FROM exemplaires 
                    WHERE id = :id AND statut = 'disponible'");
                $stmt->bindParam(':id', $unIdProduit, PDO::PARAM_INT);
                $stmt->execute();
                $unProduit = $stmt->fetch(PDO::FETCH_ASSOC);

                $lesProduits[] = $unProduit;
            }
        }
        return $lesProduits;
    }

    public static function trouverTousJeux(){
        $req = "SELECT * FROM exemplaires WHERE statut = 'disponible'";
        $res = AccesDonnees::query($req);
        $lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);
        return $lesLignes;
    }

}
