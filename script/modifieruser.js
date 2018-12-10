


var usertype = $("#usertype").val();


$("#typeuser").val(usertype);
if(usertype == "vendeur"){
	$("#vendeur").show();
}else if(usertype == "admin"){
	$("#typeuser").val("admin");
}else{
	$("#typeuser").val("acheteur");
}


function getval(sel)
{	
   if(sel.value == "vendeur"){
   		$("#vendeur").show();
   }else{
   		$("#vendeur").hide();
   }
}