$('.select2').select2();

$(document).on('change','#code',function(event) {

    var code = $(this).val().trim();

    var data = {
        code : code
    };

    var url = Routing.generate('produit_verify');

    var self = this;

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(res) {
        	if (res.exist == true) {
        		$(self).val('');
        		show_info('Erreur','le code est déjà utilisé','error');
        	}
        }
    })
})

$(document).on('click','#add-produit-entrepot',function(event) {
	event.preventDefault();

	var url = Routing.generate('produit_entrepot_tpl');
	console.log(url) ;
	$.ajax({
		url : url,
		type: 'GET',
		success: function(res) {
			$('.lis-produit-entrepot').append(res);
			
			$('.code').each(function() {
				$(this).val( $('#code').val() );
			});
			
			$('.select2').select2();
			
			$('.expirer').datepicker({
			    todayBtn: "linked",
			    keyboardNavigation: false,
			    forceParse: false,
			    calendarWeeks: true,
			    autoclose: true,
			    format: 'dd/mm/yyyy',
			    language: 'fr'
			});
		}
	})

	// var tpl = $('.produit-entrepot').clone();
});

$(document).on('click','#remove-produit-entrepot',function(event) {
	event.preventDefault();
	$('div.lis-produit-entrepot div.produit-entrepot:last').remove();
})

$('#produit_image').attr('src',get_picture_b64());

$(document).on('change','#image',function(event) {
  var file = document.querySelector('#image').files[0];
  getBase64(file).then((src)=>{
      $('#produit_image').attr('src',src);
  });
});

$('.expirer').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    format: 'dd/mm/yyyy',
    language: 'fr'
});

$('.summernote').Editor()

var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 100,
	height : 100
});

$(document).on('input', '#code', function(event) {
	var data = event.target.value;

	$('.code').each(function() {
		$(this).val(data);
	})

	makeCode(data)
})

function makeCode (data) {		
	qrcode.makeCode(data);
}

$(document).on('click', '#btn-save', function(event) {
	event.preventDefault();
		var val_str = [
			$('#categorie').val(),
			$('#code').val(),
			$('#qrcode img').attr('src'),
			$('#nom').val(),
			$('#unite').val(),
			$('#produit_image').attr('src'),
		] ;

		var descri_str = [
			"Categorie",
			"Code",
			"Qr Code Image",
			"Nom",
			"Unité",
			"Produit Image"
		] ;



		enregistre = true
		for (var i = 0; i < val_str.length ; i++) 
		{
			if(val_str[i] === '')
			{
				enregistre = false
				var val_descri_str = descri_str[i]
				break ;
			}
		}

	
	if (enregistre)
	{
		var val_strPro = [
			$('.entrepot'),
			$('.prix_achat'),
			$('.prix_revient'),
			$('.prix_vente'),
			$('.stock_alerte'),
			$('.fournisseur'),
			$('.stock'),
		]

		var str_descriPro = [
			"Entrepot",
			"Prix d'achat",
			"Prix de revient",
			"Prix de vente",
			"Stock Alerte",
			"Fournisseur",
			"Stock",
		]
		vide = false
		var negatif = false ;
		var elem_descriPro = ""

		for (let i = 0; i < val_strPro.length; i++) {
			const element = val_strPro[i];
			element.each(function(){
				if($(this).val() == "")
				{
					vide = true ;
					elem_descriPro = str_descriPro[i]
					return 
				}
				if((i > 0 && i < 5) || i == 6)
				{
					if($(this).val() < 0)
					{
						negatif = true ;
						elem_descriPro = str_descriPro[i]
						return 
					}
				}
				
			})

			if(vide || negatif)
			{
				break ;
			}
		}

		if(!vide && !negatif)
		{
			var data = {
				code : $('#code').val(),
				qrcode : $('#qrcode img').attr('src'),
				nom : $('#nom').val(),
				description : $('#description').parent().find('.Editor-editor').html(),
				unite : $('#unite').val(),
				categorie: $('#categorie').val(),
				produit_image : $('#produit_image').attr('src'),
				indice : toArray('.indice'),
				entrepot : toArray('.entrepot'),
				fournisseur : toArray('.fournisseur'),
				prix_achat : toArray('.prix_achat'),
				charge : toArray('.charge'),
				prix_revient : toArray('.prix_revient'),
				marge_type : toArray('.marge_type'),
				marge_valeur : toArray('.marge_valeur'),
				prix_vente : toArray('.prix_vente'),
				stock : toArray('.stock'),
				stock_alerte : toArray('.stock_alerte'),
				expirer : toArray('.expirer')
				};
				
				var url = Routing.generate('produit_save') ;
				disabled_confirm(false); 
	
				swal({
					title: "Enregistrer",
					text: "Voulez-vous vraiment enregistrer ? ",
					type: "info",
					showCancelButton: true,
					confirmButtonText: "Oui",
					cancelButtonText: "Non",
					},
					function () {
					disabled_confirm(true);
						$.ajax({
							url: url,
							type: 'POST',
							data: data,
							success: function(res) {
								show_success('Succès', 'Produit enregistré');
							}
						})
				
				});
		}
		else
		{
			if(negatif)
			{
				swal({
					type: 'error',
					title: elem_descriPro+' négatif',
					text: 'Corriger '+elem_descriPro+' !'
					// footer: '<a href="">Misy olana be</a>'
				})
			}
			else
			{
				swal({
					type: 'warning',
					title: elem_descriPro+' vide ou invalide',
					text: 'Remplissez '+elem_descriPro+' !'
					// footer: '<a href="">Misy olana be</a>'
				})	
			}

		}

	}	
	else
	{
		swal({
			type: 'warning',
			title: val_descri_str+' vide',
			text: 'Remplissez '+val_descri_str+' !'
			// footer: '<a href="">Misy olana be</a>'
		  })
	}


});

function getBase64(file) {
  return new Promise((resolve)=>{
     var reader = new FileReader();
     reader.readAsDataURL(file);
     reader.onload = function () {
       resolve(reader.result);
     };
     reader.onerror = function (error) {
       resolve(false)
     };
  })
}

$(document).on('input', '.marge_valeur', function(event) {
	event.preventDefault();

	var item = $(this).closest('div.produit-entrepot');
	var prix_achat = item.find('.prix_achat').val();
	var charge = item.find('.charge').val();
	var prix_revient = Number(prix_achat) + Number(charge);
	var calcul = Number( item.find('.marge_type').val() );
	var valeur = Number( event.target.value );
	var marge = calcul_marge(prix_revient,calcul,valeur);
	var prix_vente = prix_revient + marge;

	item.find('.prix_revient').val(prix_revient);
	item.find('.prix_vente').val(prix_vente);

});

$(document).on('change', '.marge_type', function(event) {
	event.preventDefault();

	var item = $(this).closest('div.produit-entrepot');
	var prix_achat = item.find('.prix_achat')
	var charge = item.find('.charge').val();
	var prix_revient = Number(prix_achat) + Number(charge);
	var calcul = Number( $(this).children("option:selected").val() );
	var valeur = Number( item.find('.marge_valeur').val() );
	var marge = calcul_marge(prix_revient,calcul,valeur);
	var prix_vente = prix_revient + marge;
	
	item.find('.prix_revient').val(prix_revient);
	item.find('.prix_vente').val(prix_vente);

});

$(document).on('input', '.prix_achat', function(event) {
	event.preventDefault();

	var item = $(this).closest('div.produit-entrepot');
	var prix_achat = event.target.value;
	var charge = item.find('.charge').val();
	var prix_revient = Number(prix_achat) + Number(charge);
	var calcul = Number( item.find('.marge_type').val() );
	var valeur = Number( item.find('.marge_valeur').val() );
	var marge = calcul_marge(prix_revient,calcul,valeur);
	var prix_vente = prix_revient + marge;

	item.find('.prix_revient').val(prix_revient);
	item.find('.prix_vente').val(prix_vente);

});

$(document).on('input', '.charge', function(event) {
	event.preventDefault();

	var item = $(this).closest('div.produit-entrepot');
	var prix_achat = item.find('.prix_achat').val();
	var charge = event.target.value;
	var prix_revient = Number(prix_achat) + Number(charge);
	var calcul = Number( item.find('.marge_type').val() );
	var valeur = Number( item.find('.marge_valeur').val() );
	var marge = calcul_marge(prix_revient,calcul,valeur);
	var prix_vente = prix_revient + marge;

	item.find('.prix_revient').val(prix_revient);
	item.find('.prix_vente').val(prix_vente);

});

function calcul_marge(prix_revient, calcul, valeur) {
	var marge = 0;
	if (calcul == 0) {
		marge = valeur;
	} else {
		marge = (prix_revient * valeur) / 100;
	}

	return marge;
}

function toArray(selector, type = 'default') {
    var taskArray = new Array();
    $(selector).each(function() {

        if (type == 'summernote') {
            taskArray.push($(this).parent().find('.Editor-editor').html());
        } else {
            taskArray.push($(this).val());
        }

    });
    return taskArray;
}