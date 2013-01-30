<?php
if (is_admin())
{ ?>

    <script src="adplus-request.js">
    onload=getNames("");
    </script>
    
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
            Staat dit er nou nog?
        </div>
    </div>
<?php
}
else{
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
}
?>