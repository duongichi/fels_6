<?php class WordsController extends  AppController{
    var $name = "Words"; 
    var $helpers = array('Form', 'Paginator');   
        public $components = array('Auth');
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('filter');
        }


	function index(){
        $data = $this->Word->find("all");
        $this->set("data",$data);

        $this->loadModel('Answer');
        //$meaning = $this->Answer->find('all');
        $meaning = $this->paginate("Answer");
        $this->set("meaning", $meaning);
        //$this->set('meaning', $this->paginate());

        $this->loadModel('Category');
        $category = $this->Category->find('all', array('fields' => array('category_name')));
        $this->set("category", $category);

    }

    public function filter(){
        
        $this->loadModel('User');
        $this->loadModel('Answer');
        $this->loadModel('Category');
        $this->loadModel('Learned_word');
        $this->loadModel('Lesson');
        $uid = $this->User->id;
        //$uid = 1;

        $select_input = $_POST["selectAns"];

        $radio_input = $_POST["radioAns"];

        if($radio_input == 1){

            $sql = "SELECT words.word, answers.answer
                    FROM words
                    INNER JOIN answers ON words.id = answers.word_id
                    AND answers.correct_answer_flag =1
                    INNER JOIN categories ON categories.id = words.category_id
                    WHERE categories.id = '$select_input'
                    AND (
                    words.id
                    IN (
                        SELECT word_id
                        FROM learned_words
                        INNER JOIN lessons ON learned_words.lesson_id = lessons.id
                        WHERE lessons.user_id = '$uid'
                        )
                    )
                    ";
        }

        if($radio_input == 2){

            $sql = "SELECT words.word, answers.answer
                    FROM words
                    INNER JOIN answers ON words.id = answers.word_id
                    AND answers.correct_answer_flag =1
                    INNER JOIN categories ON categories.id = words.category_id
                    WHERE categories.id = '$select_input'
                    AND (
                    words.id
                    NOT IN (
                        SELECT word_id
                        FROM learned_words
                        INNER JOIN lessons ON learned_words.lesson_id = lessons.id
                        WHERE lessons.user_id = '$uid'
                        )
                    )
                    ";
        }

        if($radio_input == 3){

            $sql = "SELECT words.word, answers.answer
                    FROM words
                    INNER JOIN answers ON words.id = answers.word_id
                    AND answers.correct_answer_flag =1
                    INNER JOIN categories ON categories.id = words.category_id
                    WHERE categories.id = '$select_input'
                    ";            
         }

        $filter = $this->Word->query($sql);
        $this->set("filter", $filter);

    }
}
?>


