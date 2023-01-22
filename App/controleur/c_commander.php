<?php

include 'App/modele/M_Commande.php';

/**
 * Controleur pour les commandes
 * @author Loic LOG
 */
switch ($action) {
    case 'confirmerCommande' :
        if (!$clientSession) {
            header('Location: index.php?uc=authentication&redirect[us]=commander&redirect[action]=confirmerCommande');
            die();
        }
        $lesIdJeu = getLesIdJeuxDuPanier();
        M_Commande::creerCommande($clientSession['id'], $lesIdJeu);
        supprimerPanier();
        afficheMessage("Commande enregistrée");
        $uc = '';
        break;
}



