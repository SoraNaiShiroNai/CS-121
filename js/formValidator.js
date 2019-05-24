$(document).ready(function(){

  $("#adduser").click(validate);
  $("#logIn").click(accountLog);
  
    function validate(){

		if($("[name=firstname]").val()=="" || $("[name=surname]").val()=="" || $("[name=default_address]").val()=="" || $("[name=email]").val()==""||
		  $("[name=phone_number]").val()=="" || $("[name=password1]").val()=="" || $("[name=password2]").val()==""){
			alert("Required fields must be filled!");
		}
		else if(!isDigit($("[name=phone_number]").val())){
		  alert("Phone Number must only contain digits!");
		}
		else if($("[name=password1]").val()!= $("[name=password2]").val()){
		  alert("Passwords do not match");
			return false;
		}
		else {
		$("#newUser").submit();
		$("#newUser").reset();
		}
	}
	
	function isDigit(text){
		if (text.match("[0-9]+")) {
		  return true;
		}
		else {
			return false;
		}
	}	
	
	function accountLog(){
		
		if($("[name=email]").val()==""|| $("[name=password]").val()==""){
			//alert("Required fields must be filled!");
			$("#exampleModalLabel1").append("\nRequired fields must be filled!");
		}
		else {
			$("#logInDetails").submit();
			$("#logInDetails").reset();
		}
	}
});
