<?php
	echo "<table>";
	foreach($friends_activity as $item_friends_activity){
		
		echo "<tr>";
		echo $item_friends_activity['users']['username']." da hoc 20 tu trong Category ".$item_friends_activity['categories']['category_name']." vao ngay ". $item_friends_activity['lessons']['learned_date']. ".";
		echo "</tr></br></br></br>";

	}
	echo "</table>"
?>
