


var usertype = $("#usertype").val();


$("#typeuser").val(usertype);
if(usertype == "vendeur"){
	$("#vendeur").show();
	$("#address").hide();
}else if(usertype == "admin"){
	$("#typeuser").val("admin");
	$("#address").hide();
}else{
	$("#typeuser").val("acheteur");
	$("#address").show();
}


function getval(sel)
{	
   if(sel.value == "vendeur"){
   		$("#vendeur").show();
   }else{
   		$("#vendeur").hide();
   }
}

