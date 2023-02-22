<?php

class M_Client {

    /**
     * Crée une ligne dans la table client avec les informations en paramètre
     * Les informations sont vérifiés par la fonction estValide()
     *
     * @param string $identifiant
     * @param string $password
     * @param string $nom
     * @param string $prenom
     * @param string $ville
     * @param int $cp
     * @param string $rue
     * @param string $mail
     * @return array en cas d'erreurs
     */
    public static function creerClient($identifiant, $password, $nom, $prenom, $ville, $cp, $rue, $mail) {
        if($erreurs = static::estValide($identifiant, $password, $nom, $prenom, $ville, $cp, $rue, $mail)){
            return $erreurs;
        };

        $pdo = AccesDonnees::getPdo();
        $password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare(
            "INSERT INTO client(identifiant, mot_de_passe, nom, prenom, nom_ville, cp, adresse_rue, email) 
            VALUES (:identifiant, :password, :nom, :prenom, :ville, :cp, :rue, :mail)");
        $stmt->bindParam(":identifiant", $identifiant, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $stmt->bindParam(":ville", $ville, PDO::PARAM_STR);
        $stmt->bindParam(":cp", $cp, PDO::PARAM_INT);
        $stmt->bindParam(":rue", $rue, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->execute();
    }
    

    public static function lastClient(){
        $idClient = AccesDonnees::getPdo()->lastInsertId();
        return $idClient;
    }

    /**
     * Cherche les informations d'un client dans la base de donnée
     * via son id
     *
     * @param int $idClient
     * @return array
     */
    public static function trouverClientParId($idClient){
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "SELECT * 
            FROM client 
            WHERE id = :idClient");
        $stmt->bindParam(":idClient", $idClient, PDO::PARAM_INT);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        return $client;
    }
    /**
     * Cherche les infos d'un client dans la base de donnée 
     * via son identifiant et son mot de passe
     *
     * @param string $identifiant
     * @param string $password
     * @return array
     */
    public static function trouverClientParIdentifiantEtMDP($identifiant, $password){
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "SELECT * 
            FROM client 
            WHERE identifiant = :identifiant");
        $stmt->bindParam(":identifiant", $identifiant, PDO::PARAM_STR);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client && password_verify($password, $client["mot_de_passe"])) {
            return $client;
        }

        return false;
    }
/**
 * Modifie les informations contenues dans la table client
 * selon les informations saisies par l'utilisateur et validés par la fonction:
 * estValideProfil()
 * 
 * @param int $idClient
 * @param string $nom
 * @param string $prenom
 * @param string $ville
 * @param int $cp
 * @param string $rue
 * @param string $mail
 * @return array en cas d'erreurs
 */
    public static function changerClientInfo($idClient, $nom, $prenom, $ville, $cp, $rue, $mail){
        if($erreurs = static::estValideProfil($nom, $prenom, $ville, $cp, $rue, $mail)){
            return $erreurs;
        };

        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare(
            "UPDATE client 
            SET nom = :nom, 
            prenom = :prenom, 
            nom_ville = :ville, 
            cp = :cp, 
            adresse_rue = :rue, 
            email = :mail 
            WHERE client.id = :idClient");
        $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $stmt->bindParam(":ville", $ville, PDO::PARAM_STR);
        $stmt->bindParam(":cp", $cp, PDO::PARAM_INT);
        $stmt->bindParam(":rue", $rue, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->bindParam(":idClient", $idClient, PDO::PARAM_INT);
        $stmt->execute();
    }
    
/**
 * Valide les informations saisis par l'utilisateur lors de l'inscription
 * return un tableau avec les erreurs rencontrés
 *
 * @param int $identifiant
 * @param string $password
 * @param string $nom
 * @param string $prenom
 * @param string $ville
 * @param int $cp
 * @param string $rue
 * @param string $mail
 * @return array
 */
    public static function estValide($identifiant, $password, $nom, $prenom, $ville, $cp, $rue, $mail) {
        $erreurs = [];
        if ($identifiant == "") {
            $erreurs[] = "Il faut saisir le champ identifiant";
        }
        if ($password == "") {
            $erreurs[] = "Il faut saisir le champ mot de passe";
        } else if (!estUnPassword($password)) {
            $erreurs[] = "Erreur de password. Votre mot de passe doit comporter un minimum de 8 caractères et un maximum de 90 caractères. Au moins un caractère doit être en majuscule, un caractère doit être en minuscule, un chiffre, un caractère spécial ($ ou & ou + ou , ou : ou ; ou = ou ? ou @ ou # ou _ ou -).";
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
            $erreurs[] = "Erreur de code postal. Le CP doit comporter de 5 chiffres.";
        }
        if ($mail == "") {
            $erreurs[] = "Il faut saisir le champ mail";
        } else if (!estUnMail($mail)) {
            $erreurs[] = "Erreur de mail. Le symbol @ - est obligatoire. (Exemple d'un mail - example@example.com)";
        }
        return $erreurs;
    }

    /**
     * Vérifie les informations que l'utilisateur souhaite modifier
     * return un tableau avec les erreurs rencontrés
     *
     * @param string $nom
     * @param string $prenom
     * @param string $ville
     * @param int $cp
     * @param string $rue
     * @param string $mail
     * @return array
     */
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
            $erreurs[] = "Erreur de code postal. Le CP doit comporter de 5 chiffres.";
        }
        if ($mail == "") {
            $erreurs[] = "Il faut saisir le champ mail";
        } else if (!estUnMail($mail)) {
            $erreurs[] = "Erreur de mail. Le symbol @ - est obligatoire. (Exemple d'un mail - example@example.com)";
        }
        return $erreurs;
    }

}
