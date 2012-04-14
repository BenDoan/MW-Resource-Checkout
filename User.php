<?php
	class User{
		public $userName;
		public $firstName;
		public $lastName;
		public $password;
		
		public function User($userName, $firstName, $lastName, $password){
			$this->userName=		$userName;
			$this->firstName=		$firstName;
			$this->lastName=		$lastName;
			$this->password=		$password;
		}
	}
?>