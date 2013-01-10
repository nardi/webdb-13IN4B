<?php
/*
-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
FILE: mymysqli.class.php
AUTHORS: W. Kaper
DATE: december 2006
STATE: testing

This is a wrapper for a mysqli-object.
It represents one connection to a specific database.

It has 'safe' methods that guarantee the showing or logging of errors.
It uses fatalerror.inc.php for this purpose.

Currently, it only supports a policy of using prepared statements.
It wraps myqli prepared-statements in "mystatement" objects.
*/

include_once 'fatalerror.inc.php';
include_once 'mystatement.class.php';

//default database connection parameters
//production
define('DBSERVER', 'dbm.science.uva.nl');
define('DBNAME', 'student39');
define('USER_WRITE', 'student39');
define('PASS_WRITE', 'DL9O.qdA');
define('USER_READ', 'student39');
define('PASS_READ', 'DL9O.qdA');
//testing
/*
define('DBSERVER', 'uvathuis01.uvathuis.local');
define('DBNAME', 'claimwachtw');
define('USER_WRITE', 'root');
define('PASS_WRITE', 'xxxxx');
define('USER_READ', 'root');
define('PASS_READ', 'xxxxx');
*/

//the class itself
class mymysqli {
    private $dbserver = DBSERVER;        //(string) server name
    private $dbname = DBNAME;            //(string) database name
    private $user_write = USER_WRITE;    //(string) database user having writing rights
    private $pass_write = PASS_WRITE;    //(string) database password for writing user
    private $user_read = USER_READ;      //(string) database user having read-only rights
    private $pass_read = USER_READ;      //(string) database password for read-only user
    private $state = FALSE;              //(string) either 'read', 'write' or FALSE
    private $mysqli= FALSE;              //(mysqli object) live database connection
    private $error = '';                 //(string) last errormessage caused by prepare
    
    /*
    Constructor of the class
    Optionally start the connection, in "read" or "write" state
    Optionally override default connection parameters
    */
    public function __construct(
        $state=FALSE, $dbserver='', $dbname='', $user_write='', $pass_write='',
        $user_read='', $pass_read=''
    ) {
        if ($dbserver) $this->dbserver = $dbserver;
        if ($dbname) $this->dbname = $dbname;
        if ($user_write) $this->user_write = $user_write;
        if ($pass_write) $this->pass_write = $pass_write;
        if ($user_read) $this->user_read = $user_read;
        if ($pass_read) $this->pass_read = $pass_read;
        if ($state) {
            $this->connect($state);
        }
    }
    
    /*
    Connect in one of two states, 'write' or 'read' (the default)
    */
    public function connect($state='read') {
        $this->mysqli = 
            ($state=='write') ?
            ( new mysqli($this->dbserver, $this->user_write, $this->pass_write, $this->dbname) ) :
            ( new mysqli($this->dbserver, $this->user_read, $this->pass_read, $this->dbname) ) ;
        if (mysqli_connect_errno()) {
            err_die("Connect error: ".mysqli_connect_error());
        }
        $this->state = ($state=='write') ? ('write') : ('read');
        return TRUE;
    }
    
    /*
    Destructor of this class. It frees client memory.
    */
    public function __destruct() {
        $this->mysqli->close();
    }

    /*
    Get the state
    'read' or 'write' or FALSE if not connected
    */
    public function getState() {
        return $this->state;
    }
    
    /*
    Get errormessage produced by last prepare call
    It returns '' if last prepare was faultless
    */
    public function getError() {
        return $this->error;
    }
    
    /*
    Return a prepared statement
    $sql (string), an sql string containing '?' to represent parameters
    $show (bool), whether to echo the sql-string
    */
    public function prepare($sql='', $show=FALSE) {
        if ($show) echo "\n". $sql ."<br />\n" ;
        $stmt = $this->mysqli->prepare($sql) ;
        $this->error = ($stmt) ? ('') : $this->mysqli->error;
        return ($stmt) ? (new mystatement($stmt, $sql, $this->mysqli)) : (FALSE);
    }
    
    /*
    Return a prepared statement (safe version)
    On error, the script dies with a standard debug-message
    */
    public function sprepare($sql='', $show=FALSE) {
        if ($show) echo "\n". $sql ."<br />\n" ;
        $stmt = $this->mysqli->prepare($sql) ;
        if (! $stmt) err_die(
            'Prepare error: '.$this->mysqli->error.
            ', <br />caused by this SQL: '.$sql
        );
        return ($stmt) ? (new mystatement($stmt, $sql, $this->mysqli)) : (FALSE);
    }
		
	/*
	Just for testing: a query function that returns a result-object
	Disable it after testing!
	*/
	public function query($sql='') {
	    return $this->mysqli->query($sql); 
	}    
}
?>