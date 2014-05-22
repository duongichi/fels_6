<?php

    echo "<table>
          <tr>
            <td><b>Japanese</b></td>
            <td><b>Vietnamese</b></td>
          </tr>";

        foreach($filter as $item){
            echo "<tr>";
            echo "<td>".$item['words']['word']."</td><td>".$item['answers']['answer']."</td>";
            echo "</tr>";
        }

    echo "</table>";


?>
