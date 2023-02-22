<section id="authentication">
    <form method="POST" action="index.php?uc=authentication&action=loginClient">
        <fieldset>
            <legend>Authentication</legend>
            <p>
                <label for="identifiant">Identifiant</label>
                <input id="identifiant" type="text" name="identifiant" maxlength="90">
            </p>
            <p>
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" minlength="8" maxlength="90">
            </p>
            <p>
                <input type="submit" value="Valider" name="Valider">
                <input type="reset" value="Annuler" name="Annuler"> 
            </p>
    </form>
</section>