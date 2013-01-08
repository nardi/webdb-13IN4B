<?php
function query2html( $result )
{
	$nfields = mysql_num_fields($result);
	
	echo "<table border='0'>";
	// printing table headers
  //echo "<tr>";
	//for($i=0; $i<$nfields; $i++){
	//	$field = mysql_fetch_field($result);
	//	echo "<th>{$field->name}</th>";
	//}
	//echo "</tr>\n";
	// printing table rows
	while($row = mysql_fetch_row($result)){
		echo "<tr>";

		// $row is array... foreach( .. ) puts every element
		// of $row to $cell variable
		foreach($row as $cell)
			echo "<td>$cell</td>";

		echo "</tr>\n";
	}
	echo "</table>";
}
?>
