<?php
// app/Controller/UsersController.php
/**
	* 
	*/
	class UsersController extends AppController
	{
		public $components = array('Auth');
		
		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow('add', 'logout', 'get_my_activity', 'get_friends_activity', 'user_list', 'follow', 'unfollow');
		}

		public function index() {
			$this->User->recursive = 0;
			$this->set('users', $this->paginate());
		}

/*		public function view($id = null) {
			$this->User->id = $id;
			if(!$this->User->exists()) {
				throw new NotFoundException(__('Invalid User.'));
			}
			$this->set('user', $this->User->read(null, $id));
		}*/

		public function login() {
			if($this->request->is('post')) {
				if($this->Auth->login()) {
					return $this->redirect($this->Auth->redirect());
				}
				$this->Session->setFlash(__('Invalid username or password, try again.'));
			}
		}

		public function add() {
			if($this->request->is('post')) {
				$this->User->create();
				if($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved.'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash(
					__('The user could not be saved.'));
			}
		}

		public function edit($id = null) {
			$this->User->id = $id;
			if(!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user.'));
				
			}
			if($this->request->is('post') || $this->request->is('put')) {
				if($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved.'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash(
					__('The user could not be saved. Please try again !'));
			} else {
				$this->request->data = $this->User->read(null, $id);
				unset($this->request->data['User']['password']);
			}
		}

		public function delete($id = null) {
			$this->request->onlyAllow('post');

			$this->User->id = $id;
			if(!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user.'));
				
			}
			if($this->User->delete()) {
				$this->Session->setFlash(__('User deleted.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('User was not deleted.'));
			return $this->redirect(array('action' => 'index'));
		}

		public function logout() {
			return $this->redirect($this->Auth->logout());
		}

		public function user_list() {
			$this->set('title_for_layout', 'User list');
			$this->User->recursive = 0;
			$this->set('user_role', $this->Auth->user('role'));
			$this->set('users', $this->paginate());
		}

		public function get_my_activity(){
			$uid = $this->User->id;
			$sql = "SELECT category_name, user_id, learned_date 
					FROM lessons INNER JOIN categories 
					ON lessons.category_id = categories.id 
					WHERE user_id = $uid 
					ORDER BY lessons.learned_date ";
			$my_activity = $this->User->query($sql);
			$this->set("my_activity", $my_activity);
		}

		public function get_friends_activity(){
			
			$uid = $this->User->id;

			$sql = "SELECT username, learned_date, category_name
				FROM follows
				INNER JOIN users ON follows.follower_id = users.id
				INNER JOIN lessons ON follows.follower_id = lessons.user_id
				INNER JOIN categories ON lessons.category_id = categories.id
				WHERE follows.user_id = $uid;
				order by DATE_FORMAT(lessons.learned_date, '%d/%m/%Y') DESC";
			


			$friends_activity = $this->User->query($sql);
			$this->set("friends_activity", $friends_activity);	
		}

	public function follow($id = null){
		$this->request->onlyAllow('post');
		$uid = $this->User->id;
		$uid = 1;

		$sql = "SELECT COUNT(*) as total_id
		FROM follows
		WHERE user_id = $uid AND follower_id = $id";

		$this->loadModel('Follow');
		$test = $this->Follow->query($sql);
		$this->set("test", $test);

		if ($this->request->is('post')){

			$count = intval($test[0][0]['total_id']);
			
			if ($count == 0) {
				$this->Session->setFlash(__('followed !' ));

				$this->Follow->Save(
					    array(
					        'user_id' => $uid,
					        'follower_id' => $id
					    )
					);

				return $this->redirect(array('action' => 'user_list'));
			}

			if ($a == 1) {
				$this->Session->setFlash(__('Aldeary Follow'));
				return $this->redirect(array('action' => 'user_list'));
			}
			
		}
	}		

	public function unfollow($id = null){
		$this->request->onlyAllow('post');
		$uid = $this->User->id;
		$uid = 1;

		$sql = "SELECT COUNT(*) as total_id
			FROM follows
			WHERE user_id = $uid AND follower_id = $id";

			$this->loadModel('Follow');
			$test = $this->Follow->query($sql);
				
			$this->set("test", $test);

			if ($this->request->is('post')){

				$count = intval($test[0][0]['total_id']);
					
				if ($count == 1) {
					$this->Session->setFlash(__('Unfollowed !' ));
					$this->Follow->deleteAll(array('Follow.user_id' => $uid, 'Follow.follower_id'=> $id));
					return $this->redirect(array('action' => 'user_list'));
				}

				if ($count == 0) {
					$this->Session->setFlash(__('You not follow this person'));
					return $this->redirect(array('action' => 'user_list'));
				}
			}
	}

	public function import_csv(){
			
	}

		
}
?>
