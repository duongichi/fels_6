<?php
if($data==NULL){
    echo "<h2>Data Empty</h2>";
}
else{

    echo "<table>";
    echo "<tr><td><b>Category</b></td></tr>";
    echo "<tr><td><select>";
        foreach($category as $item_category){
            echo "<option value=\"".$item_category['Category']['id']."\">".$item_category['Category']['category_name']."</option>"; 
        }
    echo "</select></td></tr>";
    echo '<tr><form action="">';
        echo '<td><input type="radio" name="radAnswer" value="learned">Learned</td>';
        echo '<td><input type="radio" name="radAnswer" value="unlearned">Unlearned</td>';
        echo '<td><input type="radio" name="radAnswer" value="all">All</td>';
    echo "</tr>";
    echo "<tr><td>";
        echo '<button type="button"> Filter </button>'; 
    echo "</form></td></tr>";
    echo "</table>";

    echo "<table>
          <tr>
            <td><b>Japanese</b></td>
            <td><b>Vietnamese</b></td>
          </tr>";

        foreach($meaning as $item){
            echo "<tr>";
            foreach($data as $item_data){
                if($item['Answer']['word_id'] == $item_data['Word']['id'] && $item['Answer']['correct_answer_flag'] == 1)
                    echo "<td>".$item_data['Word']['word']."</td><td>".$item['Answer']['answer']."</td>";
            }
            echo "</tr>";
        }


    echo "</tr>";
    echo "</table>";
}
?>
