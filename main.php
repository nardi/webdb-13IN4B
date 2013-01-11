<?php
    /*
     * Gebruik met: require 'main.php';
     */

    function show_error_page($exception)
    {
        echo "Er ging iets mis bij het laden van deze pagina:</br></br>" . $exception->getMessage();
    }
    
    set_exception_handler('show_error_page');
    
    function connect_to_db()
    {
        $mysqli = new mysqli("localhost", "webdb13IN4B", "trestunu", "webdb13IN4B");
        if ($mysqli->connect_errno)
        {
            throw new Exception($mysqli->connect_error);
        }
        return $mysqli;
    }
?>