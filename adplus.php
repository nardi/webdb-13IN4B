<?php
if (is_admin())
{ ?>

    <script src="adplus-request.js"></script>

    <div class="centered-container">
        <div id="filters">
            <!-- Zoekbalk hier... -->
            <form>
            Email:
            <input type="text" name="email" onkeyup="getNames(this.value)" />
            </form>
        </div>
        
        <hr /> <br />
        
        <div id = "userlist">
        Hier komen de gebruikers...
        </div>
    </div>
<?php
}
else{
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
}
?>