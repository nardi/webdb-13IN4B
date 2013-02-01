<?php
    require 'product-verwijderen.php';
    ?><script>alert("boe")</script><?php
    if(is_admin()){
        function product_verwijderen_conf_func($pid, $titel){
            echo "<img src='images/labels/verwijderd.gif' /> <br /> 
            <strong> Weet u zeker dat u $titel wilt verwijderen?.</strong><br />
            <div id='buttons'>
                <div id='ja'>
                    <form id='DeleteItemConf' action='products.php' method='post'>
                        <div id='ItemVerwijderen'>
                            <input type='submit' value='Ja' name='submitButtonYes' id='DeleteSubmitButtonYes' title='Product verwijderen'/>
                        </div>
                    </form>
                </div>
                <div id='nee'>
                    <form id='backToProduct' action='redirect_to(item-description.php?id=$pid)' method='post'>
                        <div id='ItemNietVerwijderen'>
                            <input type='submit' value='Nee' name='submitButtonNo' id='DeleteSubmitButtonNo' title='Product verwijderen'/>
                        </div>
                    </form>
                </div>
            </div>";
        }
        if(isset($_POST['deleteId']) && isset($_POST['deleteTitel'])){
            $iid=$_POST['deleteId'];
            $titel=$POST['deleteTitel'];
            product_verwijderen_conf_func($iid, $titel);
        }
    }
    
    else
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
?>