<?php

class Postdata {
	public function acquire($fname,$fval=null, $tval=null) {
		if (empty($_POST[$fname])) {
			$this->$fname = $fval;
			return false;
		} else if ($tval !== null) {
			$this->$fname = trim($tval);
			return true;
		} else {
			$this->$fname = trim($_POST[$fname]);
			return true;
		}
	}
}
