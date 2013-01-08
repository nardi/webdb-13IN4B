<?php
  # enable sessions
  session_start();
  unset($_SESSION["authenticated"]);

  $redirect = $_SERVER['HTTP_REFERER'];
  header("Location: $redirect", true, 302); // 302: "Moved temporarily"
  exit();
?>
