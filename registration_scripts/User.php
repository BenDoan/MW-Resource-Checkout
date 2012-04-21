<?php
	class User{
		public $userName;
		public $firstName;
		public $lastName;
		public $password;
        public $email;

		public function User($userName, $firstName, $lastName, $password, $email){
			$this->userName=		$userName;
			$this->firstName=		$firstName;
			$this->lastName=		$lastName;
			$this->password=		$password;
            $this->email=           $email;
		}
	}
?>
