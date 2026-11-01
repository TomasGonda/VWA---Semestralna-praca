<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<section>
    <form class="contact-form">
        <div class="form-group">
            <label for="first-name">Meno</label>
            <input type="text" id="first-name" name="first-name" placeholder="Zadajte meno" required>
        </div>

        <div class="form-group">
            <label for="last-name">Priezvisko</label>
            <input type="text" id="last-name" name="last-name" placeholder="Zadajte priezvisko" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <label for="phone">Telefón</label>
            <input type="tel" id="phone" name="phone" placeholder="+421 900 123 456" required>
        </div>

        <div class="form-group">
            <label for="note">Poznámka</label>
            <textarea type="note" id="note" name="phone" rows="5" placeholder="Poznámka pre firmu" required></textarea>
        </div>

        <button type="submit">Odoslať</button>
    </form>
</section>