<section id="compte">
    <p><strong>Mes jeux:</strong></p>
    <table class="commandes">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Nom de jeu</th>
                <th>Prix</th>
                <th>Categorie</th>
                <th>État</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $counter = 1;
                foreach ($lesCommandes as $uneCommande) {
                    $description = $uneCommande['description'];
                    $prix = $uneCommande['prix'];
                    $nomCategorie = $uneCommande['nom'];
                    $etat = $uneCommande['etat'];
                    $statut = $uneCommande['statut'];
                    ?>
                    <tr>
                    <td><?= $counter;?></td>
                    <td><?= $description;?></td>
                    <td><?= $prix;?></td>
                    <td><?= $nomCategorie;?></td>
                    <td><?= $etat;?></td>
                    <td><?= $statut;?></td>
                </tr>
                    <?php
                    $counter++;
                }
            ?>
        </tbody>
    </table>
    <form method="POST" action="index.php?uc=compte&action=changerProfil"> 
        <fieldset>
            <legend>Mon copmte</legend>
            <p>
                <label for="nom">Nom</label>
                <input id="nom" type="text" name="nom" value="<?= $clientSession['nom'] ?>" maxlength="90">
            </p>
            <p>
                <label for="prenom">Prenom</label>
                <input id="prenom" type="text" name="prenom" value="<?= $clientSession['prenom'] ?>" maxlength="90">
            </p>
            <p>
                <label for="ville">Ville</label>
                <input id="ville" type="text" name="ville" value="<?= $clientSession['nom_ville']?>" maxlength="45">
            </p>
            <p>
                <label for="cp">Code postal</label>
                <input id="cp" type="text" name="cp" value="<?= $clientSession['cp'] ?>" size="5" maxlength="5">
            </p>
            <p>
                <label for="rue">Rue</label>
                <input id="rue" type="text" name="rue" value="<?= $clientSession['adresse_rue']?>" maxlength="255">
            </p>
            <p>
                <label for="mail">Email </label>
                <input id="mail" type="text"  name="mail" value="<?= $clientSession['email'] ?>" maxlength="100">
            </p> 
            <p>
                <input type="submit" value="Valider" name="Valider">
                <input type="reset" value="Annuler" name="Annuler"> 
            </p>
    </form>
</section>