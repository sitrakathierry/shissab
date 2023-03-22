load_list_prix_produit();

$(document).on('click', '.cl_statut_produit', function(event) {
	event.preventDefault();
	var html = 'Produit : ' + $(this).attr("data-produit") + '<span class="badge-warning">#'+$(this).attr('data-code')+'</span>';
	$('#status-produit-nom').html('');
	$('#date-expiration').val($(this).attr("data-expirer"));	
	$('#status-produit-nom').append(html);
	$('#btn-save-status').attr('data-id', $(this).attr("data-id"));
	var status = parseInt($(this).attr('data-status'));
	if(isNaN(status)) status = 0;list_variation
	if(status === 0){
		$('#status-actif').prop('checked', true);
		$('#status-desactiver').prop('checked', false);
	}
	if(status === 1){
		$('#status-desactiver').prop('checked', true);
		$('#status-actif').prop('checked', false);
	}
	$('#produit-status-modal').modal('show');
});

$('#date-expiration').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    format: 'dd/mm/yyyy',
    language: 'fr'
});

$(document).on('click', '#btn-save-status', function(event) {
	event.preventDefault();
    var status = $(document).find('input:radio[name="status-value"]:checked').val(),    
        prixProduit = $(this).attr('data-id'),
        expirer = $('#date-expiration').val();

    var url = Routing.generate('produit_save_statut_prix_produit');

    var data = {
        prixProduit : prixProduit,
        status : status,
        expirer : expirer
    };

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(res) {            
			show_info('Succès', 'Modification enregistré');
			location.reload();
        }
    });
});

function load_list_prix_produit() {
    var data = {
        produit_id : $('#id_produit').val()
    };

    var url = Routing.generate('produit_list_variation');

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(res) {
            $('#list_variation').html(res);
        }
    });
}

// $(document).ready(function(){
//     var elem_3 = document.querySelector('.js-switch');
//     var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });
// });

$(document).on('click','#btn-save-variation', function(event) {
    event.preventDefault();
    var inputForm = [
        $('#variation_entrepot'),
        // $('#variation_indice'),
        $('#variation_prix_vente'),
        $('#variation_stock')
    ]
    enregistre = true ;
    var textForm = [
        'Entrepot',
        // 'Indice',
        'Prix de Vente',
        'Stock'
    ]
    // console.log($('#variation_entrepot').val()) ;
    message = '' ;
    negatif = false ;
    for (let i = 0; i < inputForm.length; i++) {
        const element = inputForm[i];
        if(element.val() == "" || element.val() == 0)
        {
            enregistre = false ;
            message = textForm[i] ;
            break ;
        }

        if(i > 1)
        {
            if(element.val() < 0)
        {
            enregistre = false ;
            message = textForm[i] ;
            negatif = true ;
            break ;
        }
        }
    }

    if(enregistre)
    {
        var data = {
            id_produit : $('#id_produit').val(),
            variation_entrepot : $('#variation_entrepot').val(),
            variation_indice : $('#variation_indice').val(),
            variation_prix_vente : $('#variation_prix_vente').val(),
            variation_stock : $('#variation_stock').val(),
            variation_operation : $('#variation_operation').val(),
        };

        var url = Routing.generate('produit_save_variation');

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
                        show_success('Succès', 'Variation Produit enregistré');
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
                title: message+' Négatif',
                text: 'Veuillez corriger '+message
            })
        
        }
        else
        {
            swal({
                type: 'warning',
                title: message+' Vide',
                text: 'Veuillez remplir '+message
            })
        
        }
        
    }

});

$(document).on('click','.edit-variation',function(event) {
    event.preventDefault();

    var id = $(this).data('id');

    $.ajax({
        data: {
            id: id
        },
        type: 'POST',
        url: Routing.generate('produit_editor_variation'),
        dataType: 'html',
        success: function(data) {
            show_modal(data,'Modification Variation');
        }
    });
});

$(document).on('click','#id-deduct', function(e) {
    var check = $('input[name="is_deduct"]:checked').val(); 
    console.log(check);

    (check === undefined) ? $('.kl-stock').addClass('hidden') : $('.kl-stock').removeClass('hidden');
    (check === undefined) ? $('.kl-deduction').addClass('hidden') : $('.kl-deduction').removeClass('hidden');
    (check === undefined) ? $('#stock_deduit').attr('required', false) : $('#stock_deduit').attr('required', true);
    (check === undefined) ? $('#deduisement_type').attr('required', false) : $('#deduisement_type').attr('required', true);
})

var selected = $('.kl-select').find('option:selected');
if (selected.val() == 2 ) {
    $('#id-cause').val('');
    $('#id-cause').attr('required', true);
    $('.kl-cause').removeClass('hidden');
}

 $(document).on('change','.kl-select', function (e) {
    var selected = $(this).find('option:selected');
    if (selected.val() == 2 ) {
        console.log("cause");
        $('#id-cause').val('');
        $('#id-cause').attr('required', true);
        $('.kl-cause').removeClass('hidden');
    }else{
        console.log("sans cause");
        $('#id-cause').val('');
        $('#id-cause').attr('required', false);
        $('.kl-cause').addClass('hidden');
    }
})


$(document).on('click','#id_save_variation', function(event) {
    event.preventDefault();

    if(parseInt($('#stock_deduit').val()) < 0)
    {
        swal({
                type: 'error',
                title: 'Valeur négative',
                text: 'Corriger votre valeur'
            })
    }
    else
    {
        var data = {
            prix_vente : $('#variation_prix_vente_edit').val(),
            id_variation : $('#id_variation_edit').val(),
            is_deduct : $('#id-deduct').val(),
            stock_deduit : $('#stock_deduit').val(),
            type : $('#deduisement_type').val(),
            cause : $('#id-cause').val()
        };

        var url = Routing.generate('produit_update_variation');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(res) {
                show_info('Succès', 'Variation Produit enregistré');
                close_modal();
                load_list_prix_produit();
                location.reload() ;
            }
        });
    }

});

$(document).on('click','.delete-variation',function(event) {

    event.preventDefault();

    var id = $(this).data('id'); 

    var url = Routing.generate('produit_delete_variation', { id : id });

    disabled_confirm(false); 

    swal({
            title: "SUPPRIMER",
            text: "Voulez-vous vraiment supprimer ? ",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Oui",
            cancelButtonText: "Non",
        },
        function () {
            disabled_confirm(true);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    show_info('Succès', 'Suppression éffectué');
                    close_modal();
                    load_list_prix_produit();
                    location.reload() ;
                }
            });
    });


});