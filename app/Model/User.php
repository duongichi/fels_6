<?php
// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('AppModel', 'Model');

class User extends AppModel {
	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A username is required.'
			)
		),
		'password' => array(
		 	'required' => array(
		 		'rule' => array('notEmpty'),
		 		'message' => 'A password is required.'
		 	)
		),
		'email' => array(
		 	'required' => array(
		 		'rule' => array('notEmpty'),
		 		'message' => 'An Email is required.'
		 	)
		),
		'role' => array(
			'valid' => array(
				'rule' => array('inList', array('admin', 'author')),
				'message' => 'Please enter a valid role.',
				'allowEmpty' => false
			)
		)
	);

	public function beforeSave($options = array()) {
		if(isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}
}
?>