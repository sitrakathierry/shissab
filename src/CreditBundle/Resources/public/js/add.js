$(document).ready(function(){

    $(document).on('change', '.designation', function(event) {
        event.preventDefault();
        var type_designation = $(this).closest('tr').find('.type_designation').val();

        if (type_designation == '1') {
            var prixvente = $(this).children("option:selected").data('prixvente');
            $(this).closest('tr').find('.prix').val(prixvente);
        } else {
            // var prixvente = '';
            $(this).closest('tr').find('.f_ps_duree').trigger('change');
        }

    });

    $(document).on('change','.f_ps_duree',function(event) {
        event.preventDefault();

        var tr = $(this).closest('tr');
        var id = tr.find('.designation').children('option:selected').val();
        var duree = $(this).children('option:selected').val();

        var data = {
            id : id,
            duree : duree
        };

        var url = Routing.generate('facture_service_prix');

        $.ajax({
            url : url,
            type : 'POST',
            data : data,
            success: function(res) {
                if (res.prix) {
                    tr.find('.prix').val(res.prix).trigger('input');
                } else {
                    tr.find('.prix').val('');
                }
            }
        })
    })

    $(document).on('change','.devise',function(event) {
        event.preventDefault();

        var montantprincipal = $(this).children('option:selected').data('montantprincipal');
        var montantconversion = $(this).children('option:selected').data('montantconversion');
        var total = $('#montant_total').val();

        var montant_converti = (Number( total ) * Number( montantconversion )) / Number( montantprincipal );

        $(this).closest('tr').find('.montant_converti').val( montant_converti.toFixed(2) );
    })

    $('.select2').select2();
    
	$(document).on('change', '.type_designation', function(event) {
		event.preventDefault();
		
		var soustable_selector = $(this).closest('tr').find('td.soustable');
		var designation_selector = $(this).closest('tr').find('.designation');
	    var type = $(this).children('option:selected').val();
	    var url = Routing.generate('facture_produitservice_tpl', { type : type });

	    var self = this;

	    $.ajax({
	    	url : url,
	    	type : 'GET',
	    	success: function(res) {
	    		soustable_selector.html(res.tpl);


	    		if (type == 3) {
            		designation_selector.addClass('hidden');
            		$(self).closest('tr').find('.designation').addClass('hidden');
            		$(self).closest('tr').find('.designation_autre_container').removeClass('hidden');

            		$('.designation_autre').summernote();

	    		} else {

	    			designation_selector.removeClass('hidden');
            		$(self).closest('tr').find('.designation').removeClass('hidden');
            		$(self).closest('tr').find('.designation_autre_container').addClass('hidden');

		    		designation_selector.html('');

		            var data = res.designations;
		            var options = "<option value=''></option>";

		         	$.each(data, function(index, item) {

		                if (type == 1) {
		                    options += '<option data-prixvente="'+ item.prix_vente +'" value="' + item.id + '">' + item.nom + ' - ' + item.prix_vente + ' KMF</option>';
		                } else {
		                    options += '<option value="' + item.id + '">' + item.nom + '</option>';
		                }

		            });
		            designation_selector.append(options);

                    $('.designation').select2();

	    		}


	    	}
	    })

	});

	$(document).on('click', '.btn-add-row', function(event) {
        event.preventDefault();

        var id = $('#id-row').val();
        var new_id = parseInt(id) + 1;
        
        var produit_options = $('.cl_produit').html();

        var a = '<td><div class="form-group"><div class="col-sm-12"><select class="form-control type_designation" name="type_designation[]"><option></option><option value="1">PRODUIT</option><option value="2">SERVICE</option></select></div></div></td>';
        var b = '<td><div class="form-group"><div class="col-sm-12"><select class="form-control designation" name="designation[]"><option></option></select><div class="designation_autre_container hidden"><textarea class="designation_autre" name="designation_autre[]"></textarea></div></div></div></td>';
        var c = '<td class="soustable"></td>';
        var d = '<td><div class="form-group"><div class="col-sm-12"><input type="number" class="form-control prix" name="prix[]" ></div></div></td>';
        var e = '<td><div class="form-group"><div class="col-sm-4"><select class="form-control remise_type_ligne" name="remise_type_ligne[]"><option value="0">%</option><option value="1">Montant</option></select></div><div class="col-sm-8"><input type="number" class="form-control remise_ligne" name="remise_ligne[]" ></div></div></td>';
        var f = '<td class="td-montant"><div class="form-group"><div class="col-sm-12"><input type="number" class="form-control montant" name="montant[]" ></div></div></td>';

        var markup = '<tr>' + a + b + c + d + e + f + '</tr>';
        $("#table-commande-add tbody#principal").append(markup);
        $('#id-row').val(new_id);

        calculTotalHT();


    });

    $(document).on('click', '.btn-remove-row', function(event) {
        event.preventDefault();
        var id     = parseInt($('#id-row').val());
        var new_id = id - 1;

        if (new_id >= 0) {
            $('#id-row').val(new_id);
            $('.designation_autre').destroy();
            $('#table-commande-add tbody tr:last').remove();
        } else {
            show_info("Attention", 'Le tableau devrait contenir au moins une ligne','error');
        }

        $('.designation_autre').summernote();

        calculTotalHT();
    });

    $(document).on('input','.f_ps_qte',function (event) {
        var qte = event.target.value;
        var prix_selector = $(this).closest('tr').find('.prix');
        var total_selector = $(this).closest('tr').find('.montant');

        var remise_type_ligne = $(this).closest('tr').find('.remise_type_ligne').val();
        var remise_ligne = $(this).closest('tr').find('.remise_ligne').val();

        if (qte) {
        	var total = Number( prix_selector.val() ) * Number( qte );
        } else {
        	var total = Number( prix_selector.val() );
        }

        var remise_ligne_montant = 0;

        if (remise_type_ligne == '1') {
            remise_ligne_montant = Number( remise_ligne );
        } else {
            remise_ligne_montant = (total * Number( remise_ligne )) / 100;
        }

        total = total - remise_ligne_montant;

        total_selector.val( total );
        calculTotalHT()
    });

    $(document).on('change','.remise_type_ligne',function(event) {


        var prix = Number( $(this).closest('tr').find('.prix').val() );
        var type = Number( $(this).closest('tr').find('.type_designation').val() );

        if (type == 1 || type == 3) {

            var remise_type_ligne = $(this).children("option:selected").val();
            var remise_ligne = $(this).closest('tr').find('.remise_ligne').val();

            var qte = Number( $(this).closest('tr').find('.f_ps_qte').val() );
            var total = prix;

            if (qte) {
                total = qte * prix
            }

            var remise_ligne_montant = 0;

            if (remise_type_ligne == '1') {
                remise_ligne_montant = Number( remise_ligne );
            } else {
                remise_ligne_montant = (total * Number( remise_ligne )) / 100;
            }

            total = total - remise_ligne_montant;

            var montant_selector = $(this).closest('tr').find('.montant');
            montant_selector.val(total);
        } else {

            var remise_type_ligne = $(this).children("option:selected").val();
            var remise_ligne = $(this).closest('tr').find('.remise_ligne').val();

            var qte = Number( $(this).closest('tr').find('.f_ps_periode').val() );
            var total = prix;

            if (qte) {
                total = qte * prix
            }

            var remise_ligne_montant = 0;

            if (remise_type_ligne == '1') {
                remise_ligne_montant = Number( remise_ligne );
            } else {
                remise_ligne_montant = (total * Number( remise_ligne )) / 100;
            }

            total = total - remise_ligne_montant;

            var montant_selector = $(this).closest('tr').find('.montant');
            montant_selector.val(total);
        }
        
        calculTotalHT();


    });

    $(document).on('input','.remise_ligne',function(event) {

        var prix = Number( $(this).closest('tr').find('.prix').val() );
        var type = Number( $(this).closest('tr').find('.type_designation').val() );

        if (type == 1 || type == 3) {

            var remise_type_ligne = $(this).closest('tr').find('.remise_type_ligne').val();
            var remise_ligne = event.target.value;

            var qte = Number( $(this).closest('tr').find('.f_ps_qte').val() );
            var total = prix;

            if (qte) {
                total = qte * prix
            }

            var remise_ligne_montant = 0;

            if (remise_type_ligne == '1') {
                remise_ligne_montant = Number( remise_ligne );
            } else {
                remise_ligne_montant = (total * Number( remise_ligne )) / 100;
            }

            total = total - remise_ligne_montant;

            var montant_selector = $(this).closest('tr').find('.montant');
            montant_selector.val(total);
        } else {

            var remise_type_ligne = $(this).closest('tr').find('.remise_type_ligne').val();
            var remise_ligne = event.target.value;

            var qte = Number( $(this).closest('tr').find('.f_ps_periode').val() );
            var total = prix;

            if (qte) {
                total = qte * prix
            }

            var remise_ligne_montant = 0;

            if (remise_type_ligne == '1') {
                remise_ligne_montant = Number( remise_ligne );
            } else {
                remise_ligne_montant = (total * Number( remise_ligne )) / 100;
            }

            total = total - remise_ligne_montant;

            var montant_selector = $(this).closest('tr').find('.montant');
            montant_selector.val(total);
        }
        
        calculTotalHT();


    })

    $(document).on('input','.prix',function (event) {

        var qte_selector = $(this).closest('tr').find('.f_ps_qte');
        var periode_selector = $(this).closest('tr').find('.f_ps_periode');
        var prix = event.target.value;
        var total_selector = $(this).closest('tr').find('.montant');

        var remise_type_ligne = $(this).closest('tr').find('.remise_type_ligne').val();
        var remise_ligne = $(this).closest('tr').find('.remise_ligne').val();

        if ( qte_selector.val() ) {
        	var total = Number( qte_selector.val() ) * Number( prix );
        } else {

        	if (periode_selector.val()) {
        		var total = Number( periode_selector.val() ) * Number( prix );
        	} else {
        		var total = prix;
        	}

        }

        var remise_ligne_montant = 0;

        if (remise_type_ligne == '1') {
            remise_ligne_montant = Number( remise_ligne );
        } else {
            remise_ligne_montant = (total * Number( remise_ligne )) / 100;
        }

        total = total - remise_ligne_montant;

        total_selector.val( total );
        calculTotalHT()
    });

    $(document).on('input','.f_ps_periode',function (event) {
        var periode = event.target.value;
        var prix_selector = $(this).closest('tr').find('.prix');
        var total_selector = $(this).closest('tr').find('.montant');

        var remise_type_ligne = $(this).closest('tr').find('.remise_type_ligne').val();
        var remise_ligne = $(this).closest('tr').find('.remise_ligne').val();

        if (periode) {
        	var total = Number( prix_selector.val() ) * Number( periode );
        } else {
        	var total = Number( prix_selector.val() );
        }

        var remise_ligne_montant = 0;

        if (remise_type_ligne == '1') {
            remise_ligne_montant = Number( remise_ligne );
        } else {
            remise_ligne_montant = (total * Number( remise_ligne )) / 100;
        }

        total = total - remise_ligne_montant;

        total_selector.val( total );
        calculTotalHT()
    });

    $(document).on('click', '#btn-save', function(event) {
        event.preventDefault();

    	// var data = $('#form-commande').serializeArray();
        var designation = ""
        var enregistre = true
        $('.type_designation').each(function(){
            negatif = false
            if($(this).val() == 1)
            {
                designation = "Produit"
                qte_credit = $(this).parent().parent().parent().parent().find('.f_ps_qte').val()
                if(parseInt(qte_credit) < 0)
                {
                    negatif = true
                    enregistre = false
                    return
                }
                else if(qte_credit == "")
                {
                    negatif = false  
                    enregistre = false
                    return
                }
                
            }
            else if($(this).val() == 2)
            {
                designation = "Service"
                enregistre = true
            }
            else
            {
                enregistre = false
            }
        })
    
        
        if(enregistre)
        {
        var data = {
            client : $('#client').val(),
            type_designation : toArray('type_designation'),
            designation : toArray('designation'),
            f_ps_qte : toArray('f_ps_qte'),
            f_ps_periode : toArray('f_ps_periode'),
            f_ps_duree : toArray('f_ps_duree'),
            designation_autre : toArray('designation_autre','summernote'),
            prix : toArray('prix'),
            remise_type_ligne : toArray('remise_type_ligne'),
            remise_ligne : toArray('remise_ligne'),
            montant : toArray('montant'),
            montant_ht : $('#montant_ht').val(),
            remise_type : $('#remise_type').val(),
            remise : $('#remise').val(),
            montant_remise : $('#montant_remise').val(),
            tva_type : $('#tva_type').val(),
            tva : $('#tva').val(),
            montant_tva : $('#montant_tva').val(),
            montant_total : $('#montant_total').val(),
            lettre : $('#lettre').text(),
            date : $('#date').val(),
            lieu : $('#lieu').val(),
            devise : $('.devise').val(),
            montant_converti : $('.montant_converti').val(),
        };

        if (data.client == '') {
            show_info('Attention','Champs obligatoire','warning');
            return;
        }

    	var url = Routing.generate('credit_save');

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
            			show_success('Succès', 'Vente à crédit enregistré');
            		}
            	});
              
          });
        }
        else
        {
            if(designation == "")
            {
                swal({
                    type: 'info',
                    title: "Designation non selectionnée",
                    text: "Séléctionner une désignation ",
                    })
            }
            else
            {
                if(negatif)
                {
                    swal({
                        type: 'error',
                        title: "Quantité Négatif",
                        text: "Vérifier la quantité",
                        })
                }
                else
                {
                    swal({
                        type: 'info',
                        title: "Quantité vide ou invalide",
                        text: "Remplissez ou corriger la quantité",
                        })
                }
            }
            
        }

    });

    function toArray(selector, type = 'default') {
        var taskArray = new Array();
        $("." + selector).each(function() {

            if (type == 'summernote') {
                taskArray.push($(this).code());
            } else {
                taskArray.push($(this).val());
            }

        });
        return taskArray;
    }

    $(document).on('input', '#remise', function(event) {
        var remise = event.target.value;
        calculTotalRemise(remise);
        calculTotalTva( Number( $('#tva').val() ) );
        calculTotal();
    });

    $(document).on('change','#remise_type',function(event) {
        event.preventDefault();
        calculTotalRemise( Number( $('#remise').val() ) );
        calculTotalTva( Number( $('#tva').val() ) );
        calculTotal();
    });

    $(document).on('input', '#tva', function(event) {
        var tva = event.target.value;
        calculTotalRemise( Number( $('#remise').val() ) );
        calculTotalTva(tva)
        calculTotal();
    });

    $(document).on('change','#tva_type',function(event) {
        event.preventDefault();
        calculTotalRemise( Number( $('#remise').val() ) );
        calculTotalTva( Number( $('#tva').val() ) );
        calculTotal();
    });

    var montant_ht = Number( $('#montant_ht').val() );
    var montant_remise = Number( $('#montant_remise').val() );
    var montant_tva = Number( $('#montant_tva').val() ) ;
    var montant_total = Number( $('#montant_total').val() ) ;

    function calculTotalHT() {

        montant_ht = 0;

        $('table#table-commande-add > tbody  > tr').each(function(index, tr) { 
           
           var montant_selector = $(this).find(".montant");

           var montant = montant_selector.val();

           montant_ht += Number(montant);
          
        });
       
        $('#montant_ht').val(montant_ht);

        calculTotalRemise( Number( $('#remise').val() ) );

        calculTotalTva( Number( $('#tva').val() ) );

        calculTotal();
    
    }

    function calculTotalRemise(remise) {

        var remise_type = $('#remise_type').val();

        if (remise_type == 0) {
            montant_remise = (montant_ht * remise) / 100;
        } else {
            montant_remise = remise;
        }

        $('#montant_remise').val(montant_remise);
    }

    function calculTotalTva(tva) {
        // montant_tva = (montant_ht * tva) / 100;

        var tva_type = $('#tva_type').val();

        if (tva_type == 0) {
            montant_tva = (montant_ht * tva) / 100;
        } else {
            montant_tva = tva;
        }

        $('#montant_tva').val(montant_tva);
    }

    function calculTotal() {

        montant_total = (montant_ht - montant_remise) + Number( montant_tva );
       
        $('#montant_total').val(montant_total);

        var devise_lettre = $('#devise_lettre').val();

        var l = NumberToLetter(montant_total) ;

        $('#lettre').html(l + ' ' + devise_lettre);
        $('.devise').trigger('change');

    }




});