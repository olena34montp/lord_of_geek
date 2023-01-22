﻿<?php
include 'App/modele/M_categorie.php';
include 'App/modele/M_exemplaire.php';

/**
 * Controleur pour la consultation des exemplaires
 * @author Loic LOG
 */
switch ($action) {
    case 'voirJeux' :
        $categorie = filter_input(INPUT_GET, 'categorie');
        if ($categorie) {
            $lesJeux = M_Exemplaire::trouveLesJeuxDeCategorie($categorie);
        } else {
            $lesJeux = M_Exemplaire::trouverTousJeux();
        }
        break;
    case 'ajouterAuPanier' :
        $idJeu = filter_input(INPUT_GET, 'jeu');
        $categorie = filter_input(INPUT_GET, 'categorie');
        //Affichage des infobulles
        if (!ajouterAuPanier($idJeu)) {
            afficheErreurs(["Ce jeu est déjà dans le panier !!"]);
        } else {
            afficheMessage("Ce jeu a été ajouté");
        }
        //Affichage des jeux
        if ($categorie) {
            $lesJeux = M_Exemplaire::trouveLesJeuxDeCategorie($categorie);
        } else {
            $lesJeux = M_Exemplaire::trouverTousJeux();
        }
        break;
    default:
        $lesJeux = [];
        break;
}

$lesCategories = M_Categorie::trouveLesCategories();
