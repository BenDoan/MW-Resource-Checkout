<?php
	class User{
		public $username;
		public $firstName;
		public $lastName;
		public $password;
        public $email;

		public function User($username, $firstName, $lastName, $password, $email){
			$this->username=		$username;
			$this->firstName=		$firstName;
			$this->lastName=		$lastName;
			$this->password=		$password;
            $this->email=           $email;
		}
	}
?>
