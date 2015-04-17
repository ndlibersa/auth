/*
**************************************************************************************************************************
** CORAL Authentication Module v. 1.0
**
** Copyright (c) 2010 University of Notre Dame
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


$(document).ready(function(){

	updateUsers();

});
 


function updateUsers() {

  $.ajax({
	 type:       "GET",
	 url:        "ajax_htmldata.php",
	 cache:      false,
	 data:       "action=getUsers",
	 success:    function(html) {
		$("#div_users").html(html);
		tb_reinit();
		bind_removes();
	 }


  }); 
}

  
function submitUserForm(){
  //if (validateForm() === true) {
	// ajax call to add/update
	$.post("ajax_processing.php?action=submitUser", { loginID: $("#textLoginID").val(), editLoginID: $("#editLoginID").val(), password: $("#password").val(), adminInd: getCheckboxValue('adminInd')  } ,
		function(data){

			tb_remove();		
			updateUsers();
			return false;
			
		}
	);


	//return false;
  
  //}
}  

  function bind_removes(){


  	 $(".deleteUser").unbind('click').click(function () {
	  if (confirm("Do you really want to delete this user?") == true) {
		  $.ajax({
			 type:       "GET",
			 url:        "ajax_processing.php",
			 cache:      false,
			 data:       "action=deleteUser&loginID=" + $(this).attr("id"),
			 success:    function(html) { 
				 updateUsers();
			 }



		 });
	  }			
  	 });
  }