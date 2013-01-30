<?php
/* Door deze check wordt, m.b.v. main.php gekeken of de gebruiker de juiste privileges heeeft.
*/
if (is_owner())
{ ?>

    <script src="adplus-request.js"></script>
    
    <!-- Het volgende formulier kijkt, met behulp van een XMLHTTPRequest bij elke 
         ingevoerde letter of er een gebruiker is met die (combinatie van) letter(s)
         in zijn/haar email
    -->
    <div class="centered-container">
        <div id="filters">
            <form>
            Email:
            <input type="text" name="email" onkeyup="getNames(this.value)" />
            </form>
        </div>
        
        <hr /> <br />
        
        <div id = "userlist">
            Begin met typen om gebruikers weer te geven...
        </div>
    </div>
<?php
}
else{
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
}
?>