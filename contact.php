<?php include './cookies.php'; ?>
<?php include './header.php'; ?>

<section class="contact-form-section">
<h2>Formulaire de contact</h2>
<div class="contact-form">
    <form action="./submit_contact.php" method="POST">
        <h3>Nous contacter</h3>
        <p>Nous vous répondrons dans les plus brefs délais.</p>
        <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
        
        <fieldset>
            <legend>Informations de contact</legend>
            <div class="form-group-contact">
                <label for="first_name">Nom :</label>
                <input type="text" class="input-form-name" name="first_name" id="first_name" placeholder="Votre nom" required>
            </div>

            <div class="form-group-contact">
                <label for="last_name">Prénom :</label>
                <input type="text" class="input-form-surname" name="last_name" id="last_name" placeholder="Votre prénom" required>
            </div>
        
            <div class="form-group-contact">
                <label for="email">Adresse e-mail :</label>
                <input type="email" class="input-form-email" name="email" id="email" placeholder="exemple@exemple.com" required>
            </div>

            <div class="form-group-contact">
                <label for="phone">Numéro de téléphone :</label>
                <input type="tel" class="input-form-phone" name="phone" id="phone" placeholder="123-456-7890" required>
            </div>
        </fieldset>

        <div class="form-group-contact">
            <label for="message">Message :</label>
            <textarea name="message" class="input-form-msg" placeholder="Votre message" required></textarea>
        </div>

        <button type="submit">Envoyer</button>
    </form>
</div>
</section>

<?php include './footer.php'; ?>
