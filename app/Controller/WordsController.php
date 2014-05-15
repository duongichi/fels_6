<?php class WordsController extends  AppController{
    var $name = "Words"; 
 
	function index(){
        $data = $this->Word->find("all");
        $this->set("data",$data);

        $this->loadModel('Answer');
        $meaning = $this->Answer->find('all');
        $this->set("meaning", $meaning);

        $this->loadModel('Category');
        $category = $this->Category->find('all');
        $this->set("category", $category);

    }

    function filter(){

    }
    
}