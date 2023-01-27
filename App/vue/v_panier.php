<section>
    <img src="public/images/panier.gif"	alt="Panier" title="panier"/>
    <?php
    foreach ($lesJeuxDuPanier as $unJeu) {
        $id = $unJeu['id'];
        $description = $unJeu['description'];
        $image = $unJeu['image'];
        $prix = $unJeu['prix'];
        $etat = $unJeu['etat'];
        $statut = $unJeu['statut'];
        ?>
        <p>
            <img src="public/images/jeux/<?php echo $image ?>" alt=image width=100 height=100 />
            <p>Nom : <?= $description ?></p>
            <p>Etat : <?= $etat ?></p>
            <p>Statut : <?= $statut?></p>
            <p><?= "Prix : " . $prix . " Euros" ?>
            <a href="index.php?uc=panier&jeu=<?php echo $id ?>&action=supprimerUnJeu" onclick="return confirm('Voulez-vous vraiment retirer ce jeu ?');">
                <img src="public/images/retirerpanier.png" TITLE="Retirer du panier" >
            </a>
        </p>
        <?php
    }
    ?>
    <br>
    <a href=index.php?uc=commander&action=confirmerCommande>
        <img src="public/images/commander.jpg" title="Confirmer commande" >
    </a>
</section>
