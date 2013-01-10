<?php
  # Step-by-step log in example.
  # Robert Belleman, University of Amsterdam
  # R.G.Belleman@uva.nl
  #
  # New in this version:
  # - Javascript functions added to:
  #   - set focus to username or password field
  #   - blink HTML elements with name="blink"

  # Switch to SSL connection if necessary.
  # note the two '=' and '@' in the following:
  if (@$_SERVER['HTTPS'] !== 'on')
  {
    # Note: this only works if https is on default port
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect", true, 301); // 301: "Moved permanently"
    exit();
  }

  # enable sessions
  session_start();

  if (!empty($_POST['username'])) {

    $success = false;

    # open database connection using mysqli
    $dbconn = new mysqli("localhost", "webdb1250", "vekust55", "webdb1250");
    if (mysqli_connect_errno()) {
      die("Connect failed: " . mysqli_connect_error());
    }

    # prepare SQL statement
    $stmt = $dbconn->prepare('SELECT 1 FROM users1 WHERE username=? AND password=MD5(?)');
    # Uncomment to quickly insert username/password in db:
    # (also need to outcomment the bind_result() statement below)
    #$stmt = $dbconn->prepare('INSERT INTO users1 ( username, password ) VALUES ( ?, MD5(?) )');

    if (!$stmt) {
      die("prepare(): " . $dbconn->error);
    }

    # bind query parameters: two strings
    $stmt->bind_param("ss", $_POST['username'], $_POST['password']);

    # bind query result
    $result = "";
    $stmt->bind_result($result);

    # execute query
    if (!$stmt->execute()) {
      die("execute(): " . $stmt->error);
    }

    # obtain query result
    $stmt->fetch();
    $stmt->free_result();
    $dbconn->close();

    if ($result === 1)
      $success = true;

    if ($success) {
      $_SESSION["authenticated"] = 1;
      $host = 'https://' . $_SERVER['HTTP_HOST'];
      $path = rtrim(dirname($_SERVER['PHP_SELF']), "/\\");
      header("Location: $host$path/homepage.php");
      exit();
    }
  }
?>
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Please login</title>
<script type="text/javascript"> 
// <![CDATA[ 
function setfocus()
{
  // put cursor in username field if empty
  if (document.forms.login.username.value == "")
  {
      document.forms.login.username.focus();
  }
  // else put cursor in password field
  else
  {
      document.forms.login.password.focus();
  }
}

function blinker()
{
  var blinks = document.getElementsByName("blink");
  for (var i=0; i<blinks.length; i++)
  {
    if (blinks[i].style.visibility == "visible")
      blinks[i].style.visibility = "hidden";
    else
      blinks[i].style.visibility = "visible";
  }
}

function whenloaded()
{
  setfocus();
  window.setInterval("blinker()", 500);
}

// ]]>
</script> 
</head>
<body onload="whenloaded()">
<?php if (count($_POST) > 0) print "<div name=\"blink\">LOGIN INCORRECT</div>"; ?>
<h1>Please login</h1>
<form name="login" method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
Username: <input name="username" type="text" value="<?php if (isset($_POST['username'])) print htmlspecialchars($_POST['username']); ?>"><br />
Password: <input name="password" type="password"><br />
<input type="submit" value="Submit">
</form>
</body>
</html>
