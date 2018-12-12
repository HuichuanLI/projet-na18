

var a = $("#nom_promo1").val();



$("#promotion").val($("#nom_promo1").val());




$("#categorie").val($("#Categorie_produit").val());


$("#categorie").change(function(){$("#Categorie_produit").val($("#categorie").val())});


$("#promotion").change(function(){$("#nom_promo1").val($("#promotion").val());});