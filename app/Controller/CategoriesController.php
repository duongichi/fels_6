<?php class CategoriesController extends  AppController{
 
    var $name = "Categories"; 
    public $components = array('Auth');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','edit','delete');
    }

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
        $role = $this->Auth->User('role');       
        $this->set("uid", $uid);
        $this->set("role", $role);

    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The category could not be saved. Please, try again.')
            );
        }
    }


    public function edit($id = null){
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid Category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The Category has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The Category could not be saved. Please, try again.')
            );
        }
    }

    public function delete($id = null){
        $this->request->onlyAllow('post');

        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid Category'));
        }
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('Category deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
}
