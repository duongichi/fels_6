<?php
if($user_role == 'admin') {
     echo $this->Html->link('Add user',
            array('controller' => 'users', 'action' => 'add'));
}
?>

<?php
while ($row = mysql_fetch_array($test)) {
    echo '<pre>';
    print_r ($test);
    echo '</pre>';}
?>
	<table>
		<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Role</th>
<?php
	if($user_role == 'admin') {
		echo "<th>Created</th>";
		echo "<th>Last modified</th>";
	}
?>

<th>Actions</th>
	</tr>

	<?php foreach ($users as $user) : ?>
	<tr>
	<td>
		<?php echo $user['User']['id']; ?>
	</td>
<td>
<?php
	echo $this->Html->link($user['User']['username'], array('action' => 'user_show', $user['User']['id']));
?>
</td>
<td>
	<?php echo $user['User']['role']; ?>
</td>
<?php
	if($user_role == 'admin') {
	echo "<td>";
	echo $user['User']['created'];
	echo "</td>";
	echo "</td>";
	}
?>
<?php
	if($user_role == 'admin') {
	echo "<td>";
	echo $user['User']['modified'];
	echo "</td>";
	echo "</td>";
	}
?>	
<td>
<?php

/* 

follow and unlfollow 

*/

        echo $this->Form->postLink('Follow', array('controller'=> 'users', 'action' => 'follow', $user['User']['id']));
        echo $this->Form->postLink('UnFollow', array('action' => 'unfollow', $user['User']['id']));
       
        if($user_role == 'admin'){
            echo "&nbsp;" . $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
            echo "&nbsp;" . $this->Form->postLink('Delete', array('action' => 'delete', $user['User']['id']),
                array('confirm' => 'Are you sure?'));
            }
        ?>
</td>
</tr>
	<?php endforeach; ?>
	<?php unset($user); ?>
</table>
