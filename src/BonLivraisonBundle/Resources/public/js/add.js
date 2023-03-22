$(document).ready(function(){

    $('.description_detail').Editor();
    $('.select2').select2();

    $(document).on('change','#bon_commande',function(event) {
        event.preventDefault();

        var bon_commande = $(this).children('option:selected').val();

        var url = Routing.generate('bon_livraison_bon_commande', { bonCommande : bon_commande });

        $.ajax({ 
            url : url,
            type : 'GET',
            success : function(res) {
                $('#client').val( res.client_id ).trigger('change');
                $('#table-commande-add tbody').html(res.tpl);
                $('.designation_autre').Editor();
                $('.description_detail').Editor();
            }
        });
    })

    $(document).on('change','#id-facture',function(event) {
        event.preventDefault();

        var facture = $(this).children('option:selected').val();

        var url = Routing.generate('bon_livraison_facture', { facture : facture });

        $.ajax({
            url : url,
            type : 'GET',
            success : function(res) {
                $('#client').val( res.client_id ).trigger('change');
                $('#table-commande-add tbody').html(res.tpl);
                $('.designation_autre').Editor();
                $('.description_detail').Editor();
            }
        });
    })

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

            		$('.designation_autre').Editor();

	    		} else {

	    			designation_selector.removeClass('hidden');
            		$(self).closest('tr').find('.designation').removeClass('hidden');
            		$(self).closest('tr').find('.designation_autre_container').addClass('hidden');

		    		designation_selector.html('');

		            var data = res.designations;
		            var options = "<option value=''></option>";

		         	$.each(data, function(index, item) {

		                if (type == 1) {
		                    options += '<option value="' + item.id + '">' + item.nom + ' - ' + item.prix_vente + ' KMF</option>';
		                } else {
		                    options += '<option value="' + item.id + '">' + item.nom + '</option>';
		                }

		            });
		            designation_selector.append(options);
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
        var c = '<td><div class="form-group"><div class="col-sm-12"><textarea class="description_detail" name="description_detail[]"></textarea></div></div></td>';
        var d = '<td class="soustable"></td>';

        var markup = '<tr>' + a + b + c + d + '</tr>';
        $("#table-commande-add tbody#principal").append(markup);
        $('#id-row').val(new_id);

        $('.description_detail').Editor();


    });

    $(document).on('click', '.btn-remove-row', function(event) {
        event.preventDefault();
        var id     = parseInt($('#id-row').val());
        var new_id = id - 1;

        if (new_id >= 0) {
            $('#id-row').val(new_id);
            $('.description_detail').destroy();
            $('#table-commande-add tbody tr:last').remove();
        } else {
            show_info("Attention", 'Le tableau devrait contenir au moins une ligne','error');
        }

        $('.description_detail').Editor(); 

    });


    $(document).on('click', '#btn-save', function(event) {
        event.preventDefault();

    	// var data = $('#form-commande').serializeArray();
        var val_str = [
            // $('#bon_commande').val(),
            $('#client').val(),
            // $('id-facture').val(),
        ]

        var val_descri = [
            // "Bon de commande",
            "Client",
            // "Facture"
        ]
        var elem_str = ""
        var enregistre = true
        var vide = false
        for (let i = 0; i < val_str.length; i++) {
            const element = val_str[i];
            if(element == "")
            {
                enregistre = false
                vide = true
                elem_str = val_descri[i]
                break
            }
        }
        
        if(enregistre)
        {
            $('.type_designation').each(function(){
                var type_designation = $(this).val()
                var designation = $(this).parent().parent().parent().parent().find('.designation').val()
                if(designation == "" && (type_designation == 1 || type_designation == 2))
                {
                    enregistre = false
                    vide = true
                    elem_str = "Designation"
                    return
                }
                if(type_designation == 1)
                {
                    var quantite = $(this).parent().parent().parent().parent().find('.f_ps_qte').val()
                    if(quantite == "" )
                    {
                        enregistre = false
                        vide = true
                        elem_str = "Quantité"
                        return
                    }
                    else if(quantite < 0)
                    {
                        enregistre = false
                        vide = false
                        elem_str = "Quantité"
                        return
                    }
                }
                else if(type_designation == 2)
                {
                    var periode = $(this).parent().parent().parent().parent().find('.f_ps_periode').val()
                    if(periode == "" )
                    {
                        enregistre = false
                        vide = true
                        elem_str = "Durée & Format"
                        return
                    }
                    else if(periode < 0)
                    {
                        enregistre = false
                        vide = false
                        elem_str = "Durée & Format"
                        return
                    }
                }
                else
                {
                    enregistre = false
                    vide = true
                    elem_str = "Type Designation"
                    return 
                }
                
                
            })
        }


        if (enregistre)
        {
            var data = {
                bon_commande : $('#bon_commande').val(),
                client : $('#client').val(),
                type_designation : toArray('type_designation'),
                designation : toArray('designation'),
                f_ps_qte : toArray('f_ps_qte'),
                f_ps_periode : toArray('f_ps_periode'),
                f_ps_duree : toArray('f_ps_duree'),
                description_detail : toArray('description_detail','summernote'),
                designation_autre : toArray('designation_autre','summernote'),
                date : $('#date').val(),
                lieu : $('#lieu').val(),
            };

            if (data.client == '') {
                show_info('Attention','Champs obligatoire','warning');
                return;
            }

            var url = Routing.generate('bon_livraison_save');

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
                        show_success('Succès', 'Bon de livraison enregistré');
                    }
                })
            });
        }
        else{
            if(vide)
            {
                swal({
                    type: 'warning',
                    title: elem_str+" Vide",
                    text: "Remplissez le champ "+elem_str+" !",
                    })
            }
            else
            {
                swal({
                    type: 'error',
                    title: elem_str+" Négatif",
                    text: "Vérifier et corriger le champ "+elem_str+" !",
                    })
            }
        }

    });

    function toArray(selector, type = 'default') {
        var taskArray = new Array();
        $("." + selector).each(function() {

            if (type == 'summernote') { 
                taskArray.push($(this).parent().find('.Editor-editor').html());
            } else {
                taskArray.push($(this).val());
            }

        });  
        return taskArray;
    }

});