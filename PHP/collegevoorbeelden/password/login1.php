<?php
  # Step-by-step log in example.
  # Robert Belleman, University of Amsterdam
  # R.G.Belleman@uva.nl
  #
  # In this version:
  # - in one file: HTML form, which calls on submit:
  # - another file: PHP code to check password.
  #
  # Unsafe:
  # - impossible to manage
  # - password readable in PHP code
  # - password readable over network

  $success = false;

  switch ($_POST['username']) {
    case "robbel":
      # note the triple '='!
      if ($_POST['password'] === "1abcde")
        $success = true;
      break;

    case "admin":
      if ($_POST['password'] === "geheim")
        $success = true;
      break;

    default:
      print("Unknown user.<br />");
      break;
  }

  if ($success)
    print("Login succesful!<br />Click <a href=\"nextpage.html\">here</a> to continue.<br />");
  else
    print("Login incorrect.<br />Click <a href=\"login1.html\">here</a> to try again.<br />");
?>
