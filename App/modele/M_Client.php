<?php

class M_Client {

    public static function creerClient($identifiant, $password, $nom, $prenom, $ville, $cp, $rue, $mail) {
        if($erreurs = static::estValide($identifiant, $password, $nom, $prenom, $ville, $cp, $rue, $mail)){
            return $erreurs;
        };
        $req = "insert into client(identifiant, mot_de_passe, nom, prenom, nom_ville, cp, adresse_rue, email) values ('$identifiant', '$password', '$nom', '$prenom', '$ville', '$cp', '$rue', '$mail')";
        $res = AccesDonnees::exec($req);
    }
    
    public static function lastClient(){
        $idClient = AccesDonnees::getPdo()->lastInsertId();
        return $idClient;
    }

    public static function trouverClientParId($idClient){
        $req = "select * from client where id = '$idClient'";
        $res = AccesDonnees::query($req);
        $client = $res->fetch(PDO::FETCH_ASSOC);
        return $client;
    }

    public static function trouverClientParIdentifiantEtMDP($identifiant, $password){
        $req = "select * from client where identifiant = '$identifiant' AND mot_de_passe = '$password'";
        $res = AccesDonnees::query($req);
        $client = $res->fetch(PDO::FETCH_ASSOC);
        //var_dump(AccesDonnees::getPdo()->errorInfo());
        return $client;
    }

    public static function changerClientInfo($idClient, $nom, $prenom, $ville, $cp, $rue, $mail){
        if($erreurs = static::estValideProfil($nom, $prenom, $ville, $cp, $rue, $mail)){
            return $erreurs;
        };
        $req = "UPDATE client
        SET nom = '$nom', 
        prenom ='$prenom', 
        nom_ville = '$ville', 
        cp = '$cp', 
        adresse_rue = '$rue', 
        email = '$mail'
        WHERE client.id = ". $idClient;
        $res = AccesDonnees::exec($req);
    }
    

    public static function estValide($identifiant, $password, $nom, $prenom, $ville, $cp, $rue, $mail) {
        $erreurs = [];
        if ($identifiant == "") {
            $erreurs[] = "Il faut saisir le champ identifiant";
        }
        if ($password == "") {
            $erreurs[] = "Il faut saisir le champ mot de passe";
        }
        if ($nom == "") {
            $erreurs[] = "Il faut saisir le champ nom";
        }
        if ($prenom== "") {
            $erreurs[] = "Il faut saisir le champ prenom";
        }
        if ($rue == "") {
            $erreurs[] = "Il faut saisir le champ rue";
        }
        if ($ville == "") {
            $erreurs[] = "Il faut saisir le champ ville";
        }
        if ($cp == "") {
            $erreurs[] = "Il faut saisir le champ Code postal";
        } else if (!estUnCp($cp)) {
            $erreurs[] = "erreur de code postal";
        }
        if ($mail == "") {
            $erreurs[] = "Il faut saisir le champ mail";
        } else if (!estUnMail($mail)) {
            $erreurs[] = "erreur de mail";
        }
        return $erreurs;
    }

    public static function estValideProfil($nom, $prenom, $ville, $cp, $rue, $mail) {
        $erreurs = [];
        if ($nom == "") {
            $erreurs[] = "Il faut saisir le champ nom";
        }
        if ($prenom== "") {
            $erreurs[] = "Il faut saisir le champ prenom";
        }
        if ($rue == "") {
            $erreurs[] = "Il faut saisir le champ rue";
        }
        if ($ville == "") {
            $erreurs[] = "Il faut saisir le champ ville";
        }
        if ($cp == "") {
            $erreurs[] = "Il faut saisir le champ Code postal";
        } else if (!estUnCp($cp)) {
            $erreurs[] = "erreur de code postal";
        }
        if ($mail == "") {
            $erreurs[] = "Il faut saisir le champ mail";
        } else if (!estUnMail($mail)) {
            $erreurs[] = "erreur de mail";
        }
        return $erreurs;
    }

}
