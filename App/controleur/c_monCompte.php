<?php
include 'App/modele/M_Commande.php';
include 'App/modele/M_Client.php';
//! TODO


//Affichage des commandes
$lesCommandes = [];


if(!empty($clientSession)){
    $lesCommandes = M_Commande::afficherCommandes($clientSession['id']);
}
switch ($action) {
    case 'changerProfil' :
        $nom = filter_input(INPUT_POST, 'nom');
        $prenom = filter_input(INPUT_POST, 'prenom');
        $ville = filter_input(INPUT_POST, 'ville');
        $cp = filter_input(INPUT_POST, 'cp');
        $rue = filter_input(INPUT_POST, 'rue');
        $mail = filter_input(INPUT_POST, 'mail');
        $erreurs = M_Client::changerClientInfo($clientSession['id'], $nom, $prenom, $ville, $cp, $rue, $mail);
      
        if ($erreurs) {
            afficheErreurs($erreurs);
        } else {
            afficheMessage("Vous avez enregistré vos changementes");
        }
        
        $_SESSION['client'] = M_Client::trouverClientParId($clientSession['id']);
        
        header('Location: index.php?uc=compte');
        die();
        
        break;

    default:
        break;
 }
