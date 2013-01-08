<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" title="naam" />
</head>
<body>
<h1>Calculate your BMI</h1>
<form action="BMI1action.php" method=post >
  <div class="label">name</div>
  <input type="text" name="name" value="" size="20">
  <div class="label">weight</div>
  <input class="measure" type="text" name="weight" value="" >
  <select class="measure" name="weightMeasure">
    <option value="kg" $wk>kg
    <option value="lbs" $wl>lbs
  </select>
  <div class="label">length</div>
  <input class="measure" type="text" name="length" value="" size="20">
  <select class="measure" name="lengthMeasure">
    <option value="cm" $lc>cm
    <option value="inch" $li>inch
  </select>
  <br/><br/><input type="submit" name="submit" value="Submit">
</form>
</body>
</html>
