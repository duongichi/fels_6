<?php

    $new_array[0] = " ";
    foreach($category as $category_item){
        $new_array[] = $category_item['Category']['category_name'];
    }
?>

<?php
if($data==NULL){
    echo "<h2>Data Empty</h2>";
}
else{

    echo $this->Form->create('Filter');
    echo "<table>";
    echo "<tr><td><b>Category</b></td></tr>";
    echo "<tr>><td>";
    echo $this->Form->input(
        'select',
        array(

            'type' =>'select',
            'name'=>'selectAns',
            'options' => $new_array
        )
    );
    echo "</tr></td>";
    echo "<tr>><td>";
    echo $this->Form->input(
        'radio',
        array(
            'type'=>'radio',
            'name'=>'radioAns',
            'options'=>array('1'=>'learned', '2'=>'unlearned', '3'=>'all')
        )
    );
    echo "</tr></td>";
    echo "<tr>><td>";

    echo $this->Form->button(
        'Click me', 
        array(
            'formaction' => Router::url(
                array('controller' => 'words','action' => 'filter')
            )
        )
    );

    echo "</tr></td>";

    echo "</table>";
    echo $this->Form->end();    



    echo $this->Paginator->prev('« Previous ', null, null, array('class' => 'disabled')); //Shows the next and previous links
    echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
    echo $this->Paginator->next(' Next »', null, null, array('class' => 'disabled')); //Shows the next and previous links
    echo " Page ".$this->Paginator->counter(); // prints X of Y, where X is current page and Y is number of pages

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

