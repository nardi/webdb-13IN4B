<?php
/*
-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
FILE: mystatement.class.php
AUTHORS: W. Kaper
DATE: december 2006
STATE: testing

This is a wrapper for a mysqli-statement-object.
It represents a prepared statement on the mysql server.

It has 'safe' methods that guarantee the showing or logging of errors.
It uses fatalerror.inc.php for this purpose.

The safe-execute method includes result-buffering as a default,
which is faster, and almost always wanted.

Limitations: you can bind only up to 5 parameters and 5 result variables.
If necessary, look below and you see how it can be extended.
*/

include_once 'fatalerror.inc.php';

class mystatement {
    private $stmt;  //(mysqli statement object) a prepared statement
    private $sql;   //(string) sql-string that created this statement
    private $params = array();//(mixed array) array of references to param variable-contents
    private $resultvars = array();//(mixed array) array of references to variabes that will hold the results
    private $mysqli; //(mysqli object) connection to database that holds the statement
    
    /* Constructor
    $stmt, a mysqli_stmt object
    */
    public function __construct($stmt, $sql, $mysqli) {
        $this->stmt = $stmt;
        $this->sql = $sql;
        $this->mysqli = $mysqli;
    }
    
    /* Throw away result before re-execution with new parameters (?)
    */
    public function free_result() {
        $this->stmt->free_result() ;
    }
    
    /* Get the raw mysqli_stmt object
    You can do the unsafe versions of the methods with it, should you need it
    */
    public function getRawStatement() {
        return $this->stmt;
    }
    
    /* Safe versions of bind_param
    There are many, because: method overloading not supported
    Variable-length argument list difficult to combine with pass by reference.
    */
    public function sbind_param1($types, &$var1) {
        $this->params = array();
        $this->params[0] =& $var1;
        return $this->stmt->bind_param($types, $var1) Or $this->perr_die();
    }
    public function sbind_param2($types, &$var1, &$var2) {
        $this->params = array();
        $this->params[0] =& $var1;
        $this->params[1] =& $var2;
        return $this->stmt->bind_param($types, $var1, $var2) Or $this->perr_die();
    }
    public function sbind_param3($types, &$var1, &$var2, &$var3) {
        $this->params = array();
        $this->params[0] =& $var1;
        $this->params[1] =& $var2;
        $this->params[2] =& $var3;
        return $this->stmt->bind_param($types, $var1, $var2, $var3) Or $this->perr_die();
    }
    public function sbind_param4($types, &$var1, &$var2, &$var3, &$var4) {
        $this->params = array();
        $this->params[0] =& $var1;
        $this->params[1] =& $var2;
        $this->params[2] =& $var3;
        $this->params[3] =& $var4;
        return $this->stmt->bind_param($types, $var1, $var2, $var3, $var4) Or $this->perr_die();
    }
    public function sbind_param5($types, &$var1, &$var2, &$var3, &$var4, &$var5) {
        $this->params = array();
        $this->params[0] =& $var1;
        $this->params[1] =& $var2;
        $this->params[2] =& $var3;
        $this->params[3] =& $var4;
        $this->params[4] =& $var5;
        return $this->stmt->bind_param($types, $var1, $var2, $var3, $var4, $var5) Or $this->perr_die();
    }
    //if there are more than 5 parameters, then the following 3 methods
    //provide a very general but clumsy way to do it
    public function reset_param() {
        $this->params = array();
    }
    public function set_param(&$var1) {
        $this->params[count($this->params)] =& $var1;
    }
    public function sbind_param($types) {
        $pars = $this->params;
        array_unshift($pars, $types);  //prepend $types
        return call_user_func_array(array($this->stmt, 'bind_param'), $pars) Or $this->perr_die();
    }
    
    /* Safe versions of bind_result
    */
    public function sbind_result1(&$var1) {
        return $this->stmt->bind_result($var1) Or $this->rerr_die();
    }
    public function sbind_result2(&$var1, &$var2) {
        return $this->stmt->bind_result($var1, $var2) Or $this->rerr_die();
    }
    public function sbind_result3(&$var1, &$var2, &$var3) {
        return $this->stmt->bind_result($var1, $var2, $var3) Or $this->rerr_die();
    }
    public function sbind_result4(&$var1, &$var2, &$var3, &$var4) {
        return $this->stmt->bind_result($var1, $var2, $var3, $var4) Or $this->rerr_die();
    }
    public function sbind_result5(&$var1, &$var2, &$var3, &$var4, &$var5) {
        return $this->stmt->bind_result($var1, $var2, $var3, $var4, $var5) Or $this->rerr_die();
    }
    //if there are more than 5 result columns, then the following 3 methods
    //provide a very general but clumsy way to do it
    public function reset_result() {
        $this->resultvars = array();
    }
    public function set_resultvar(&$var1) {
        $this->resultvars[count($this->resultvars)] =& $var1;
    }
    public function sbind_result() {
        $vars = $this->resultvars;
        return call_user_func_array(array($this->stmt, 'bind_result'), $vars) Or $this->rerr_die();
    }
    
    /* Safe version of execute
    */
    public function sexecute($buffer=TRUE) {
        $this->stmt->execute() Or err_die('Execute error: '.$this->stmt->error);
        //default buffering service
        if ($buffer) { 
            $this->stmt->store_result() Or err_die('Store_result error: '.$this->stmt->error);
        }
        return TRUE;
    }
    
    /* Safe execute that must return rows
    */
    public function rexecute() {
        $this->sexecute(TRUE);  //buffering necessary
        if ($this->stmt->num_rows==0) 
            err_die(
                'No rows returned by statement: "'.$this->sql.'", <br />'.
                'with parameters '.print_r($this->params, TRUE)
            );
        return TRUE;
    }
    
    /* Safe execute that must affect rows
    */
    public function aexecute() {
        $this->sexecute(FALSE);
        if ($this->stmt->affected_rows==0) 
            err_die(
                'No rows affected by statement: "'.$this->sql.'", <br />'.
                'with parameters '.print_r($this->params, TRUE)
            );
        return TRUE;
    }
    
    /* Safe execute that must return an insert id
    */
    public function iexecute() {
        $this->sexecute(FALSE);
        if ($this->stmt->affected_rows!=1) 
            err_die(
                'Affected rows !=1, by insert-statement: "'.$this->sql.'", <br />'.
                'with parameters '.print_r($this->params, TRUE)
            );
        if ($this->stmt->insert_id==0) 
            err_die(
                'No insert-id produced by this statement: "'.$this->sql.'", <br />'.
                'with parameters '.print_r($this->params, TRUE)
            );
        return $this->stmt->insert_id;
    }
    
    /* Safe execute that must return a mysql function value
    */
    public function fexecute() {
        $this->sbind_result1($returnval);
        $this->sexecute(TRUE);
        if ($this->stmt->num_rows!=1) 
            err_die(
                'This query is not a single mysql-function call: "'.$this->sql.'", <br />'.
                'with parameters '.print_r($this->params, TRUE)
            );
        $this->sfetch();
        return $returnval;
    }
    
    /*
    Wrappers for some statement methods and functions
    */
    public function sfetch() {
        return $this->stmt->fetch();
    }
    public function sdata_seek() {
        return $this->stmt->data_seek();
    }
    public function snum_rows() {
        return $this->stmt->num_rows;
    }
    public function saffected_rows() {
        return $this->stmt->affected_rows;
    }
    
    /*
    Versions of fetch and data_seek, that should return a row
    (So: you cant use rfetch in a while-construct! use sfetch instead)
    */
    public function rfetch() {
        return $this->stmt->fetch() Or err_die('Fetch error:'.$this->stmt->error);
    }
    public function rdata_seek() {
        return $this->stmt->data_seek() Or err_die('Data_seek error:'.$this->stmt->error);
    }
    
    //private
    
    /*
    Report error and die
    Current mysql version does not give a message at this error, it just returns false
    Therefore no ":", it would look as though something should follow.
    */
    private function perr_die() {
        err_die('Bind_param error '.$this->stmt->error);
    }
    private function rerr_die() {
        err_die('Bind_result error '.$this->stmt->error);
    }
}
?>