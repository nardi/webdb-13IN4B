<?php
    require_once '../main.php';
    require_once '../winkelwagen.class.php';
    
    session_start();
    
    $ww = Winkelwagen::try_load_from_session();
    
    foreach ($ww->get_all() as $id)
    {
        if (isset($_POST["amount-$id"]))
            $ww->change_amount($id, $_POST["amount-$id"]);
    }
    
    $ww->save_to_session();
    
    echo $ww->to_json();
?>