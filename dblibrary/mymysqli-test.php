<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>mymysqli.class.php test</title>
</head>
<body>
<h1>mymysqli.class.php test</h1>
<?php
//test this also with bad connection parameters
//to check error messages in case of non-connection
include 'mymysqli.class.php';
$mymysqli = new mymysqli('write');

//quick test to see if mysqli object exists
$result = $mymysqli->query('SELECT * FROM mydblib_test LIMIT 1');
$row = $result->fetch_assoc();
?>
<p>username: <?php echo $row['username']; ?></p>

<?
//create a statement with 1 bound parameter and 2 bound result variables
//query must return at least 1 row
$username = 'student7';
$myst = $mymysqli->sprepare('SELECT username, passw FROM mydblib_test WHERE username=?');
$myst->sbind_param1("s", $username);
$myst->sbind_result2($username, $passw);
$myst->rexecute();
$myst->sfetch();
$num = $myst->getRawStatement()->num_rows;
?>
<p>passw: <?php echo $passw; ?>, username: <?php echo $username; ?>, aantal rijen: <?php echo $num; ?></p>

<?
//To get to the following bad one: increasingly comment them out!
/*
//Same, with nonexistent username - error: nothing found
$username = 'student99';
$myst->rexecute();

//Same, but number of bound parameters does not fit
$username = 'student99';
$passw = 'passw';
$myst->sbind_param2("ss", $username, $passw);
$myst->rexecute();

//Same but number of results bound does not fit
$username = 'student7';
$myst->sbind_param1("s", $username);
$myst->sbind_result3($username, $passw, $apekool);
$myst->rexecute();

//Same, but executing without binding the parameter
$myst = $mymysqli->sprepare('SELECT username, passw FROM mydblib_test WHERE username=?');
$myst->rexecute();

//Same, but bad SQL
$myst = $mymysqli->sprepare('SELECT username, passw FROMM mydblib_test WHERE username=?');
*/

//Test of the many-parameter, many resultvar. setup
//(This elaborate setup is needed in case of 6 or more parameters)
$username = 'student7';
$passw = "'gx}iOG2e'";
$myst = $mymysqli->sprepare('SELECT username, passw FROM mydblib_test WHERE username=? AND passw=?');
$myst->reset_param();  //not strictly needed
$myst->set_param($username);
$myst->set_param($passw);
$myst->sbind_param("ss");
$myst->reset_result();  //not needed here
$myst->set_resultvar($uname);
$myst->set_resultvar($pw);
$myst->sbind_result();
$myst->rexecute();
?>
<p>passw: <?php echo $passw; ?>, username: <?php echo $username; ?>, aantal rijen: <?php echo $num; ?></p>

<?
//To get to the following bad one: increasingly comment them out!
/*
//Does it work if there are too little parameters?
$myst->reset_param();  //needed!
$myst->set_param($username);
$myst->sbind_param("s");
*/

//Or too little result vars?
$myst->reset_result();  //not needed here
$myst->set_resultvar($uname);
$myst->sbind_result();

//create an action statement that must affect at least 1 row
/*
$username = 'student98';
$passw = 'xyz98';
$myst = $mymysqli->sprepare('INSERT INTO mydblib_test (username, passw) VALUES (?,?)');
$myst->sbind_param2("ss", $username, $passw);
$myst->aexecute();
$num = $myst->getRawStatement()->affected_rows;
*/
?>
<p>Affected rows: <?php echo $num; ?></p>

<?
//now generate a key conflict by inserting the same row again
$myst->aexecute();

//action statement that should affect 1 row, but it doesn't, because not found
$myst = $mymysqli->sprepare('UPDATE mydblib_test SET passw="x" WHERE username="student99"');
$myst->aexecute();

//create an insert statement that must insert exactly 1 row and return its id
$myst = $mymysqli->sprepare('INSERT INTO mydblib_test (username, passw) VALUES ("student96","xyz96")');
$id = $myst->iexecute();
$num = $myst->getRawStatement()->affected_rows;
?>
<p>ID: <?php echo $id; ?>, Affected rows: <?php echo $num; ?></p>

<?
//create statement that should return insert-id but it does not
$myst = $mymysqli->sprepare('UPDATE mydblib_test SET passw="xxx96" WHERE username="student96"');
$id = $myst->iexecute();

//create statement that should return insert-id and affect 1 row, but it does not (not found)
$myst = $mymysqli->sprepare('UPDATE mydblib_test SET passw="xxx97" WHERE username="student99"');
$id = $myst->iexecute();

?>
</body>
</html>