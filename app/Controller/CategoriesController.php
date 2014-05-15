<?php class CategoriesController extends  AppController{
 
    var $name = "Categories"; 
    public $components = array('Auth');


 	function index(){

        $data = $this->Category->find('all');
        $this->set("data",$data);

        $this->loadModel('Word');
        $word_data = $this->Word->find('all');
        $this->set("word_data", $word_data);

        $this->loadModel('Lesson');
        $lesson = $this->Lesson->find('all');
        $this->set("lesson", $lesson);

        $uid = $this->Auth->User('id');
        $this->set("uid", $uid);

    }
}