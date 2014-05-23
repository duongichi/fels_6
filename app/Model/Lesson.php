<?php
// app/Model/User.php
App::uses('AppModel', 'Model');

class Lesson extends AppModel {
/*
* nguyen.van.huong
* 2014/05/15 : Set default $user_id = 0
*/
	public function count_learned_words($user_id = 0) {
		$totalLessons = $this->find('count', array('conditions' => $user_id));
		$count = $totalLessons * 20;

		return $count;
	}

	public function get_random_words($category_id) {
		$query = "SELECT w.id, w.word, c.category_name
		FROM words AS w
		INNER JOIN categories AS c
		ON w.category_id = c.id
		WHERE w.id NOT IN (
		SELECT word_id FROM learned_words)
		AND category_id = $category_id
		ORDER BY id ASC LIMIT 2";

		return $this->query($query);
	}

	public function get_answers_by_word_id($word_id) {
		$query = "SELECT id, answer, correct_answer_flag
		FROM answers AS a
		WHERE word_id = $word_id
		ORDER BY answer ASC";

		return $this->query($query);
	}

	public function save_lesson($user_id, $category_id) {
		$data = array(
		'user_id' => $user_id,
		'category_id' => $category_id,
		'learned_date' => 'NOW()');

		return Model::getAffectedRows($this->save($data));
	}

	public function save_learned_words($lesson_id, $word_id, $answer_id) {
		/*$data = array(
		'lesson_id' => $lesson_id,
		'word_id' => $word_id,
		'answer_id' => $answer_id);*/
		$query = "INSERT INTO learned_words (lesson_id, word_id, answer_id)
		VALUES($lesson_id, $word_id, $answer_id)";

		return Model::getAffectedRows($this->query($query));
	}

	public function save_relearn_answers($word_id, $answer_id){

		$query = "UPDATE learned_words SET answer_id = $answer_id WHERE word_id = $word_id";

		return Model::getAffectedRows($this->query($query));
	}

	public function get_learned_words($lesson_id){
		$query = "SELECT l.word_id, w.word, l.answer_id
		FROM learned_words as l
		INNER JOIN words as w ON l.word_id = w.id
		WHERE l.lesson_id = $lesson_id";
		return $this->query($query);
	}
}
?>