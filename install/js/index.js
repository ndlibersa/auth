function ShowLDAP() {
	if ($("#ldap_enabled").prop('checked')) {
		$(".ldap").prop("disabled",false);
	} else {
		$(".ldap").prop("disabled",true);
	}
}