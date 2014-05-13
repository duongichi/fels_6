<h1>Users</h1>
<?php 
    echo $this->Html->link('Add user', 
            array('controller' => 'users', 'action' => 'add'));
?>
<table>
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Role</th>
	    <th>Created</th>
        <th>Last modified</th>
        <th>Actions</th>
	</tr>

	<?php foreach ($users as $user) : ?>
	<tr>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['role']; ?>
		</td>
		<td>
			<?php echo $user['User']['created']; ?>
		</td>
		<td>
			<?php echo $user['User']['modified']; ?>
		</td>		
        <td>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $user['User']['id']),
                    array('confirm' => 'Are you sure?')); ?>
        </td>
	</tr>
	<?php endforeach; ?>
	<?php unset($user); ?>
</table>