<?php
	echo "<table>";
	foreach($my_activity as $item_my_activity){
		
		echo "<tr>";
		echo "Da hoc 20 tu trong Category ".$item_my_activity['categories']['category_name']." vao ngay ". $item_my_activity['lessons']['learned_date']. ".";
		echo "</tr></br></br></br>";

	}
	echo "</table>"
?>