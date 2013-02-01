<?php
    require 'product-verwijderen.php';
    if(is_admin()){
        function product_verwijderen_conf_func($pid, $titel){
            echo "
            <div id='pic'>
            <img src='images/labels/verwijderd.gif' />
            </div>
            <br /> 
            <div id=tekst>
                <strong> Weet u zeker dat u $titel wilt verwijderen?.</strong><br />
            </div>
            <div id='buttons'>
                <div id='ja'>
                    <form id='DeleteItemConf' action='product_verwijderen_func($pid, $titel)' method='post'>
                        <div id='ItemVerwijderen'>
                            <input type='submit' value='Ja' name='submitButtonYes' id='DeleteSubmitButtonYes' title='Product verwijderen'/>
                        </div>
                    </form>
                </div>
                <div id='nee'>
                    <form id='backToProduct' action='item-description.php?id=$pid' method='post'>
                        <div id='ItemNietVerwijderen'>
                            <input type='submit' value='Nee' name='submitButtonNo' id='DeleteSubmitButtonNo' title='Product verwijderen'/>
                        </div>
                    </form>
                </div>
            </div>";
        }
        if(isset($_POST['deleteId']) && isset($_POST['deleteTitle'])){
            $iid=$_POST['deleteId'];
            $titel=$_POST['deleteTitle'];
            product_verwijderen_conf_func($iid, $titel);
        }
    }
    
    else
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
?>