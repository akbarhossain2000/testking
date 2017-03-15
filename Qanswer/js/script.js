// JavaScript Document

function onlyNumeric(event){
	
	var k = event.keyCode;
	if(k==0) k = event.which;
	
	if((k>=48 && k<=57) || k==8 || k==9 || k==37 || k==39 || k==32){
		return true;
	}else{
		alert("Please Press Only Numeric Value!");
		return false;
	}
	
}

function onlyLetters(event){
	var code = event.keyCode;
	if(code==0) code = event.which;
	if(((code >= 65) && (code <= 90)) || code==8 || code==9 || code==32 || ((code >= 97) && (code <= 122))){
		return true;
	}else{
		alert("This field must contain only letters.");
		return false;
	}
	
}

function alphaNumeric(event){
	var code = event.keyCode;
	if(code==0) code = event.which;
	if(((code >= 48) && (code <= 57)) ||((code >= 65) && (code <= 90)) || code==8 || code==9 || code==45 || code==46 || code==95 || ((code >= 97) && (code <= 122))){
		return true;
	}else{
		alert("This field must contain only letters, digit and basic punctuation.");
		return false;
	}
	
}

/*form validation user_registration*/
function checkForm(form)
  {
    if(form.password.value != "" && form.password.value == form.re_passwd.value) {
      if(form.password.value.length < 6) {
        alert("Error: Password must contain at least six characters!");
        form.password.focus();
        return false;
      }
      if(form.password.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.password.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.password.focus();
      return false;
    }

    //alert("You entered a valid password: " + form.password.value);
    return true;
  }
  
  function checkPassword()
{
	var pass = document.getElementById('password').value;
	//alert(pass);
	$("#pass_msg").show();
	if(pass.length > 0 && pass.length < 6) 
	{
		document.getElementById('pass_note').innerHTML = "<b style='color:#FF0000'>Password too week!</b>";
	} 
	else if(pass.length >= 6 && pass.length < 10) 
	{
		document.getElementById('pass_note').innerHTML = "<b style='color:blue'>Password is normal!</b>";
	} 
	else if( pass.length >=10 ) 
	{
		document.getElementById('pass_note').innerHTML = "<b style='color:#00FF00'>Password is strong</b>";
	} else {
		document.getElementById('pass_note').innerHTML = "";
		$("#pass_msg").hide();
	}
}
/*form validation user_registration*/