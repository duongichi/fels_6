<?php
/**
* Lesson controller
*
* @author nguyen.van.huong
* @package app/Controller/UsersController.php
* @description This is class define controller to let users can start, relearn a lesson or view learned lessons list
* @date 2014/05/15
* @updated_on
*/

class LessonsController extends AppController
{
	private $random_words = array();
	private $answers = array();
	private $answers_list = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('learn', 'view_result', 'relearn');
	}

	public function index() {
	//$this->set('var',$this->Lesson->get_random_words(1));
	}

	public function learn($category_id = 0) {
		$this->set('title_for_layout', 'Learn a lesson');

		if($category_id == 0 || is_numeric($category_id) != true) {
			throw new NotFoundException(__('Invalid Category ID.'));	
		}

		$random_words_tmp = $this->Lesson->get_random_words($category_id);
		$word_count = count($random_words_tmp);
		if($word_count <= 0 ) {
			throw new NotFoundException(__('No result.'));
		}

		for($i = 0; $i < $word_count; $i++) {
			$random_words[$i]['id'] = $random_words_tmp[$i]['w']['id'];

			$word_id = $random_words[$i]['id'];
			$answers_tmp = $this->Lesson->get_answers_by_word_id($word_id);
			$answer_count = count($answers_tmp);

			for($j = 0; $j < $answer_count; $j++) {
				$answers[$word_id][$j]['id'] = $answers_tmp[$j]['a']['id'];
				$answers[$word_id][$j]['answer'] = $answers_tmp[$j]['a']['answer'];
				if($answers_tmp[$j]['a']['correct_answer_flag'] == 1) {
					$answers_list[$word_id] = $answers[$word_id][$j]['id'];
				}
			}

			$random_words[$i]['word'] = $random_words_tmp[$i]['w']['word'];
			$random_words[$i]['category_name'] = $random_words_tmp[0]['c']['category_name'];
		}

		$this->set('category_id', $category_id);
		$this->set('category_name', $random_words[0]['category_name']);
		$this->set('random_words', $random_words);	
		$this->set('answers', $answers);
		$this->set('word_count', $word_count);

		if(isset($this->request->data['finish'])) {
			array_pop($this->request->data);	
			$incorrect_total = array_diff_assoc($this->request->data, $answers_list);

			if(count($this->request->data) == 0) {
				$score = 0;
			} else {
				$score = $word_count - count($incorrect_total);

				$user_id = $this->Auth->user('id');
				$user_id = 1;
				$save_lesson_result = $this->Lesson->save_lesson($user_id, $category_id);
			
				if($save_lesson_result > 0) {
					$lesson_id = $this->Lesson->getLastInsertId();
				foreach ($this->request->data as $key => $value) {
					$word_id = $key;
					$answer_id = $value;
					$save_learned_word_result = $this->Lesson->save_learned_words(
					$lesson_id, $word_id, $answer_id);
				}

				$this->Session->write('category_name', $random_words[0]['category_name']);
				$this->Session->write('score', $score);
				$this->Session->write('word_count', $word_count);

				$this->Session->setFlash(__('You has been learned ' . $word_count .
				' words. You can re-learn by click Re-learn button below.'));
					return $this->redirect(array('action' => 'view_result', $lesson_id));
				} else {
					$this->Session->setFlash(__('Error : Lesson has not been saved.'));
				}
			}
		}
	}

	public function view_result($lesson_id = 0) {
		$this->set('title_for_layout', 'View result');

		if($lesson_id == 0 || is_numeric($lesson_id) != true) {
			throw new NotFoundException(__('Invalid Lesson ID.'));	
		}	

		$this->set('category_name', $this->Session->read('category_name'));
		$this->set('score', $this->Session->read('score'));
		$this->set('word_count', $this->Session->read('word_count'));

		$learned_words = $this->Lesson->get_learned_words($lesson_id);


		echo "<pre>";
		var_dump($learned_words);
		echo "</pre>";
	}

	public function relearn($lesson_id = null){
		
		$this->set('title_for_layout', 'Learn a lesson');

		// $this->loadModel('Lesson');
		$sql_result = $this->Lesson->Query("SELECT category_id FROM lessons WHERE lessons.id = $lesson_id");
		$category_id = $sql_result[0]['lessons']['category_id'];

		$this->loadModel('Category');
		$sql_category = $this->Lesson->Query("SELECT category_name FROM categories WHERE id = $category_id");
		$category_name = $sql_category[0]['categories']['category_name'];

		//$this->set('category_id', $category_id);

		if($category_id == 0 || is_numeric($category_id) != true) {
			throw new NotFoundException(__('Invalid Category ID.'));	
		}

		$random_words_tmp = $this->Lesson->get_learned_words($lesson_id);
		$word_count = count($random_words_tmp);
		if($word_count <= 0 ) {
			throw new NotFoundException(__('No result.'));
		}

		for($i = 0; $i < $word_count; $i++) {

			$random_words[$i]['id'] = $random_words_tmp[$i]['l']['word_id'];
			$word_id = $random_words[$i]['id'];

			$answers_tmp = $this->Lesson->get_answers_by_word_id($word_id);
			$answer_count = count($answers_tmp);

			for($j = 0; $j < $answer_count; $j++) {
				$answers[$word_id][$j]['id'] = $answers_tmp[$j]['a']['id'];
				$answers[$word_id][$j]['answer'] = $answers_tmp[$j]['a']['answer'];
				if($answers_tmp[$j]['a']['correct_answer_flag'] == 1) {
					$answers_list[$word_id] = $answers[$word_id][$j]['id'];
				}
			}

			$random_words[$i]['word'] = $random_words_tmp[$i]['w']['word'];
			// $random_words[$i]['category_name'] = $random_words_tmp[0]['c']['category_name'];
		}

		$this->set('category_id', $category_id);
		$this->set('lesson_id', $lesson_id);
		$this->set('category_name', $category_name);
		$this->set('random_words', $random_words);	
		$this->set('answers', $answers);
		$this->set('word_count', $word_count);

		if(isset($this->request->data['finish'])) {
			array_pop($this->request->data);	
			$incorrect_total = array_diff_assoc($this->request->data, $answers_list);

			if(count($this->request->data) == 0) {
				$score = 0;
			} else {
				$score = $word_count - count($incorrect_total);

				$user_id = $this->Auth->user('id');
				$user_id = 1;
				// $save_lesson_result = $this->Lesson->save_lesson($user_id, $category_id);
			
				// if($save_lesson_result > 0) {
					// $lesson_id = $this->Lesson->getLastInsertId();
					foreach ($this->request->data as $key => $value) {
						$word_id = $key;
						$answer_id = $value;
						$save_learned_word_result = $this->Lesson->save_relearn_answers(
						$word_id, $answer_id);
					}

					$this->Session->write('score', $score);
					$this->Session->write('word_count', $word_count);

					$this->Session->setFlash(__('You has been learned ' . $word_count .
					' words. You can re-learn by click Re-learn button below.'));
						return $this->redirect(array('action' => 'view_result', $lesson_id));
				// } else {
					// $this->Session->setFlash(__('Error : Lesson has not been saved.'));
				// }
			}
		}

	}

}
?>

