<table>
<tr>
<td colspan="2">
<?php
	echo $category_name . " : <span id='word_count'>1</span>/" . $word_count;
?>
</td>
</tr>
<?php
	echo $this->Form->create(null, array(
     	'url' => array('controller' => 'lessons', 'action' => 'relearn', $lesson_id)));

	$div_count = 1;	
	foreach ($random_words as $key => $value) {
		echo "<tr id=\"$div_count\"";
		if($div_count > 1) echo "style=\"display:none;\">"; else echo ">";
	echo "<td>";
	echo $value['word'];
	echo "</td>";

	echo "<td>";
	for($i = 0; $i < 4; $i++) {
		echo "<p><input type=\"radio\" name=\"" . $value['id'] ."\" value=\"" . $answers[$value['id']][$i]['id'] . "\">" . $answers[$value['id']][$i]['answer'] . "</p>";
	}
	echo "</td>";
	echo "</tr>";

	$div_count++;
	}
?>

	<tr>
	<td colspan="2" style"text-align:right">
	<button id="btnFinish" name="finish" style="display:none;" type="submit">Finish</button>

<?php echo $this->Form->end();?>

<button rel="1" id="btnNext" name="next">Next</button>

</td>
</tr>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">

	$("#btnNext").click(function() {
		var current_tr_id = parseInt($(this).attr("rel"));
		var next_tr_id = parseInt(current_tr_id + 1);
		var total_word = <?php echo $word_count;?>

	$('tr#' + current_tr_id).attr("style", "display:none");
	$('tr#' + next_tr_id).removeAttr("style");
	$('span#word_count').text(next_tr_id);

	$(this).attr("rel", next_tr_id);
	if(next_tr_id == total_word) {
		$(this).hide();
		$("#btnFinish").removeAttr("style");
		}
	});

</script>
</table>