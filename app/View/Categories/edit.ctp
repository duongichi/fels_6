<?php	echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend>
			<?php echo __('Edit Category'); ?>
		</legend>
		<?php 
			echo $this->Form->input('category_name');
		?>
	</fieldset>
<?php echo $this->Form->end(__('Save changes'));?>

