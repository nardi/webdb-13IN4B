<?php
    require '../main.php';

    $ww = Winkelwagen::try_load_from_session();
    
    foreach ($ww->get_all() as $id)
    {
        if (isset($_POST["amount-$id"]))
            $ww->change_amount($id, $_POST["amount-$id"]);
    }
    
    $ww->save_to_session();
    
    echo 'success';
?>