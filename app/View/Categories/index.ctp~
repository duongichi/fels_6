<?php
if($data==NULL){
    echo "<h2>Data Empty</h2>";
}
else{
    echo "<table>";
    foreach($data as $item){

            // Category Name

            echo "<tr><h3>".$item['Category']['category_name']."</h3></tr>";
            
            // Hoc bao nhieu tu
            
            $count = 0;
            foreach($lesson as $item_lesson){
                if(($item_lesson['Lesson']['user_id'] == $uid)&&($item_lesson['Lesson']['category_id']==$item['Category']['category_id']))
                    $count++;
            }

            echo "<tr><i>Da hoc duoc : ".$count*20 ." tu. </i></tr>";            

            // Danh sach tu trong Category

            echo "<tr><textarea>";
                foreach($word_data as $item_word){
                    if($item_word['Word']['category_id'] == $item['Category']['id'])
                        echo $item_word['Word']['word']." ";
                }
            echo "</textarea></tr>";

            // Start Lesson Button
            
            echo "<tr>";
                echo  $this->Form->button('START', array('onclick' => "location.href='".$this->Html->url(array('controller' => 'lessons','action' => 'start'))."'"));
            echo "</tr></br></br></br></br>";
    }
    echo "</table>";

}
?>