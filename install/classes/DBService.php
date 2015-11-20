<?php

class DBService {
	private $link;

	public function connect($host,$user,$pass) {
		if ($this->link = new mysqli($host,$user,$pass))
			return false;
		return "Could not connect to the server '$host'<br />MySQL Error: ".$this->link->error;
	}

	public function selectDB($dbname) {
		if ($this->link->select_db($dbname))
			return false;
		return "Unable to access the database '$dbname'.  Please verify it has been created.<br />MySQL Error: ".$this->link->error;
	}

	public function query($query) {
		if ($result = $this->link->query($query)) {
			return $result;
		} else {
			return false;
		}
	}

	public function error() {
		return $this->link->error;
	}
}
