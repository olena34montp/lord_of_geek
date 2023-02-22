<?php

/**
 * Les jeux sont rangés par catégorie
 *
 * @author Loic LOG
 */
class M_Categorie {

    /**
     * Retourne toutes les catégories sous forme d'un tableau associatif
     *
     * @return array tableau associatif des catégories
     */
    public static function trouveLesCategories() {
        $req = "SELECT * FROM categories";
        $res = AccesDonnees::query($req);
        $lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);
        return $lesLignes;
    }

}
