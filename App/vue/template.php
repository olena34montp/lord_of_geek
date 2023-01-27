<!DOCTYPE html>
<!--
Prototype de Lord Of Geek (LOG)
-->
<html>
    <head>
        <title>Lord Of Geek 2022</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="public/cssGeneral.css" rel="stylesheet" type="text/css">
        <meta charset="UTF-8">
    </head>
    <body>
        <header>
            <!-- Images En-tête -->
            <img src="public/images/logo.png" alt="Logo Lord Of Geek" />
            <div>
                <?php
                    if (!empty($clientSession)){
                        echo "<p>Bienvenue, ". $clientSession['nom'] . " " . $clientSession['prenom'] . "</p>";
                        echo "<a href='index.php?uc=authentication&action=logoutClient'> Se Deconnecter </a>";
                    }
                ?>
            </div>
            <!--  Menu haut-->
            <nav  id="menu">
                <ul>
                    <li><a href="index.php?uc=accueil"> Accueil </a></li>
                    <li><a href="index.php?uc=visite&action=voirJeux"> Voir le catalogue de jeux </a></li>
                    <li><a href="index.php?uc=panier&action=voirPanier"> Voir son panier </a></li>
                    <?php
                        if (empty($clientSession)) {
                            echo "<li><a href='index.php?uc=authentication'> Login </a></li>";
                            echo "<li><a href='index.php?uc=inscription'> Inscription </a></li>";
                        }
                        if (!empty($clientSession)) {
                            echo "<li><a href='index.php?uc=compte'> Mon compte </a></li>";
                        }
                    ?>
                </ul>
            </nav>

        </header>
        <main>

            <?php
            if(!empty($_SESSION['error'])){
                echo '﻿<div class="message">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            // Controleur de vues
            // Selon le cas d'utilisation, j'inclus un controleur ou simplement une vue
            switch ($uc) {
                case 'accueil':
                    include 'App/vue/v_accueil.php';
                    break;
                case 'visite' :
                    include("App/vue/v_jeux.php");
                    break;
                case 'panier' :
                    include("App/vue/v_panier.php");
                    break;
                case 'inscription':
                    include ("App/vue/v_inscription.php");
                    break;
                case 'authentication':
                    include ("App/vue/v_authentication.php");
                    break;
                case 'compte' :
                    include ("App/vue/v_compte.php");
                    break;
                default:
                    break;
            }
            ?>
        </main>
    </body>
</html>
