var status = $("#status").val();


if(status == "expédiée"){
	$("#expe").removeClass("disabled");
	$("#expe").addClass("complete");
} 

if(status == "livrée"){
	$("#expe").removeClass("disabled");
	$("#expe").addClass("complete");

	$("#livre").removeClass("disabled");
	$("#livre").addClass("complete");
	$("#recu").hide();
} 