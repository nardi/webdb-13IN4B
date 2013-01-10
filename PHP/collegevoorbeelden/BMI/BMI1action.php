<?php
extract($_POST);
echo "<b>Hello $name!</b>";
echo "<br/>".date('H:i, jS F');
echo "<br/>weight: $weight $weightMeasure";

if ($weightMeasure == 'lbs') {
  $weight = $weight * 0.4536;
  echo " -- or $weight kg";
}

echo "<br/>length: $length $lengthMeasure";
if ($lengthMeasure == 'inch') {
  $length = $length * 2.54;
  echo " -- or $length cm";
}

$bmi = $weight / pow($length / 100, 2);
$bmi = round($bmi, 2);
echo "<b><p>your BMI is: $bmi</p></b>";
?>


