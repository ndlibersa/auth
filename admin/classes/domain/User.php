<?php
/*
**************************************************************************************************************************
** CORAL Authentication Module v. 1.0
**
** Copyright (c) 2011 University of Notre Dame
**
** This file is part of CORAL.
**
** CORAL is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
**
** CORAL is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License along with CORAL.  If not, see <http://www.gnu.org/licenses/>.
**
**************************************************************************************************************************
*/


class User extends DatabaseObject {

	protected function defineRelationships() {}

	protected function overridePrimaryKeyName() {
		$this->primaryKeyName = 'loginID';
	}


	//used only for allowing access to admin page
	public function isAdmin(){
		if ($this->adminInd == 'Y' || $this->adminInd == '1'){
			return true;
		}else{
			return false;
		}

	}


	public function allAsArray() {
		$query = "SELECT * FROM User ORDER BY 1";
		$result = $this->db->processQuery($query, 'assoc');

		$resultArray = array();
		$rowArray = array();

		if ($result['loginID']){
			foreach (array_keys($result) as $attributeName) {
				$rowArray[$attributeName] = $result[$attributeName];
			}
			array_push($resultArray, $rowArray);
		}else{
			foreach ($result as $row) {
				foreach (array_keys($this->attributeNames) as $attributeName) {
					$rowArray[$attributeName] = $row[$attributeName];
				}
				array_push($resultArray, $rowArray);
			}
		}

		return $resultArray;
	}


	public function processLogin($password){

		$util = new Utility();
		$config = new Configuration();

		if($config->ldap->ldap_enabled=="Y"){
			$host = $config->ldap->host;
			$ldaprdn  = $config->ldap->base_dn;     // ldap rdn or dn
			$ldappass = $password;  // associated password
			$filter = "(".$config->ldap->search_key."=".$this->loginID.")"; //search filter
			$ldapport = $config->ldap->port; //ldap server port
			$bindAccount = $config->ldap->bindAccount; //bind account
			$bindPass = $config->ldap->bindPass; //bind password

			// connect to ldap server
			if($ldapport != ''){
				$ldapconn = ldap_connect($host, $ldapport)
				    or die(_("Could not connect to LDAP server."));

				ldap_set_option ($ldapconn, LDAP_OPT_REFERRALS, 0);
				ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

			}else{
				$ldapconn = ldap_connect($host)
				    or die(_("Could not connect to LDAP server."));
			}

			
			if ($ldapconn) {	
				if($bindAccount != ""){
					if($bindPass == ''){
						error_log("A bind password must be provided with a bind account");
						die(_("There is a problem with the LDAP configuration, contact your server administrator."));
					}
					//bind to ldap server
					$ldapbind = ldap_bind($ldapconn, $bindAccount, $bindPass);

				}else{
				    // binding to ldap server
				    //$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass); 
				    $ldapbind = ldap_bind($ldapconn);
				    // verify binding
				}
			    
			    if ($ldapbind) {
					//echo "LDAP bind successful...";
					$ldapSearch = ldap_search($ldapconn, $ldaprdn, $filter);
					
					if($ldapSearch){
						$ldap_result = ldap_get_entries($ldapconn, $ldapSearch);

						$success = ldap_bind($ldapconn, $ldap_result[0]['dn'], $ldappass);

						if(!$success){ return false;}
					}
					else{
					    return false;
					}
			    }else{
				return false;
			    }
			}
		}else{ // built-in auth	
			//verify the password is correct
			//get the hashed password
			$pwh = $util->hashString('sha512', $this->passwordPrefix . $password);

			//password failed!!
			if ($this->password != $pwh){
				return false;
			}
		}
		//passed password test

		//create new session
		$sessionID = $util->randomString(100);

		$session = new Session();
		$session->sessionID = $sessionID;
		$session->loginID = $this->loginID;
		$session->timestamp = date( 'Y-m-d H:i:s' );

		$session->save();

		//also set the cookie
		$util->setSessionCookie($sessionID, time() + $config->settings->timeout);
		$util->setLoginCookie($this->loginID, time() + $config->settings->timeout);

		//also set session variable
		$_SESSION['loginID'] = $this->loginID;

		return true;
	}


	public function processLogout(){

		$util = new Utility();
		$config = new Configuration();

		//delete the session record in database
		$sessionID = $util->getSessionCookie();

		if ($sessionID){
			$session = new Session(new NamedArguments(array('primaryKey' => $sessionID)));
			$session->delete();
		}

		//expire the cookie
		$util->setSessionCookie($sessionID, time() - $config->settings->timeout);

		//unset the login session variable
		unset($_SESSION['loginID']);



	}



	public function getOpenSession(){

		$util = new Utility();

		return $util->getSessionCookie();

	}


	public function getRememberLogin(){

		$util = new Utility();

		return $util->getRememberLogin();

	}


	public function setRememberLogin(){

		$util = new Utility();

		//expire in 180 days
		return $util->setRememberLogin($this->loginID, time()+60*60*24*180);

	}


	public function unsetRememberLogin(){

		$util = new Utility();

		return $util->setRememberLogin($this->loginID, time()-60);

	}

}

?>
