
<footer>
    <div class="column">
        <h2>Information</h2>
        <form action="php/footer-content/impressum.php">
            <input type="submit" value="Impressum">
        </form>
        <form action="php/footer-content/datenschutz.php">
            <input type="submit" value="Data protection">
        </form>
        <form action="php/footer-content/nutzungsbedingungen.php">
            <input type="submit" value="Terms of Use">
        </form>
    </div>
    <div class="column">
        <h2>Social Media</h2>
        <a href="www.Instagram.com">Instagram</a>
        <a href="www.facebook.com">Facebook</a>
        <a href="www.Twitter.com">Twitter</a>
    </div>
    <div class="column">
        <h2>Other</h2>
        <a href="www.uol.de">Universität Oldenburg</a>
    </div>
</footer>
<style itemscope lang="css">
    footer {
        display: grid;
        grid-template-columns: auto auto auto;
        grid-template-rows: auto;
        margin-top: 100px;
        margin-bottom: 50px;
    }

    .column {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }
</style>