<div id="navigation_buttons">
    <label>
        <?php echo "Name: ".$_SESSION["user"]->getName()." ".$_SESSION["user"]->getSurname() ?>
    </label>
    <label>
        <?php echo "Type: ".$_SESSION["user"]->getType() ?>
    </label>
</div>