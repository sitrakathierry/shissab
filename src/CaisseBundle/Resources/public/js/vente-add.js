$(document).ready(function(){

    function initializeScanner() {
        var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { 
            fps: 10, 
            qrbox: 250,
        });

        html5QrcodeScanner.render(onScanSuccess);
    }

            
    function onScanSuccess(decodedText, decodedResult) {
        // console.log(`Scan result: ${decodedText}`, decodedResult);

        var stop = false;
        $(".cl_produit option").each(function(i){
            var code = $(this).data('code');
            if (decodedText == code && stop == false) {
                var produit_id = $(this).val();
                var cl_produit = $('#table-commande-add tbody tr:last').find('.cl_produit');

                var insered = false;
                $('.cl_produit').each(function(item) {
                    if (produit_id == $(this).val()) {
                        insered = true;
                    }
                });

                if (insered) {
                    show_info('ATTENTION', ' CE PRODUIT EXISTE DÉJÀ DANS LA COMMANDE','info');
                } else {
                    if (cl_produit.val() != '' ) {
                        $('.btn-add-row').trigger('click');
                        $('#table-commande-add tbody tr:last').find('.cl_produit').val( produit_id ).trigger('change');
                    } else {
                        cl_produit.val( produit_id ).trigger('change');
                    }
                }

                stop = true;
            }
        });

        delete html5QrcodeScanner;
        initializeScanner();
    }

    initializeScanner();

    

	$('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'fr',

    });

	$('.select2').select2();    

    $(document).on('change', '.cl_produit', function(event) {
        event.preventDefault();
        var stock = $(this).find('option:selected').data('stock');
        // var prix = $(this).find('option:selected').data('prixvente');
        var code = ''+$(this).find('option:selected').data('code');
        var _tr = $(this).closest('tr');
        var produitSelected = $(this).val();
        var self = $(this)
        // $(_tr).find('.cl_qte').val(stock);

        //Config code bar
        var settings = {
          output:"css",
          bgColor: "#FFFFFF",
          color: "#000000",
          barWidth: "1",
          barHeight: "20"
        };
        var btype = "code128";

        $(_tr).find('.cl-code').html("").show().barcode(code, btype, settings);
        // $(_tr).find('.cl_prix').val(Number(prix));

        var countPanier = $('table#table-commande-add > tbody  > tr').length;
        var isFind = false;
        if(countPanier > 1){
            $('table#table-commande-add > tbody  > tr').each(function(index, tr) { 
                var produitExist = $(tr).find('.cl_produit option:selected').val();
                if($(_tr).attr('data-id') != $(tr).attr('data-id')){
                    if(produitSelected == produitExist){       
                        $(_tr).find('.cl_qte').val('');
                        $(_tr).find('.cl_prix').val('');              
                        $(_tr).find('.cl_total').val('');              
                        $(_tr).find('.cl_qte').attr('disabled','disabled');
                        $(_tr).find('.cl_prix').attr('disabled','disabled');
                        isFind = true;

                        $('.btn-remove-row').trigger('click');

                        return show_info('ATTENTION', ' CE PRODUIT EXISTE DÉJÀ DANS LA COMMANDE','warning');

                    }  
                }     
            });
        }

        if(!isFind){
            $('#btn-save').removeClass('disabled');
            if (Number(stock)) {
                $(_tr).find('.cl_qte').attr('max', stock);
                // var total = Number( stock ) * Number( prix );
                // $(_tr).find('.cl_total').val( Number(total) );
            } else {
                var total = $(_tr).find('.cl_prix').val();
            }
        }else{            
            $('#btn-save').addClass('disabled');
        }

        calculTotal();
        
        var reference = "" ;
        var url = Routing.generate("prix_produit_affiche")
        $.ajax({
            url: url, 
            type: 'POST',
            data: {idProduit:self.val()},
            success: function(res) {
                if(res.length > 0)
                {
                    if(res.length > 1)
                    {
                        var options = '<option value=""></option>' ;
                        for (let i = 0; i < res.length; i++) {
                            const element = res[i];
                            if(element.indice != "")
                            {
                                reference = element.indice
                            }
            
                            options += '<option value="'+element.prix_vente+'" data-variation="'+element.id+'" >'+element.prix_vente+' | '+reference+'</option>' ;
                        }
                    }
                    else
                    {
                        self.closest('tr').find('.cl_variation').val(res[0].id) ;
                        var options = '<option value="'+res[0].prix_vente+'" data-variation="'+res[0].id+'" >'+res[0].prix_vente+' | '+reference+'</option>' ;
                    }
                    _tr.find(".cl_prix").empty().append(options) ;
                    
                }
                else
                {
                    _tr.find(".cl_prix").empty() ;
                    swal({
                        type: 'info',
                        title: "Prix Produit vide",
                        text: "Veullez ajouter une variation de prix pour ce produit"
                    })
                }
                calculTotal();
            }
        })

    });

	$(document).on('click', '.btn-add-row', function(event) {
        event.preventDefault();
        var produits = [];
        var isFind = false;

        $('table#table-commande-add > tbody  > tr').each(function(index, tr) { 
            var produitExist = $(tr).find('.cl_produit option:selected').val();
            if(produits.length > 0){
                if(checkValue(produitExist, produits)){ 
                    isFind = true;
                    $('#btn-save').addClass('disabled');
                    show_info("Contrôle Securité", 'Commande non valide','info');
                }  
            } 
            produits.push(produitExist);    
        });

        if(isFind) return;
        $('#btn-save').removeClass('disabled');

        var id = $('#id-row').val();
        var new_id = Number(id) + 1;
        
        var produit_options = $('.cl_produit').html();

        var a = '<td><div class="form-group"><div class="col-sm-12"><select class="form-control select2 cl_produit" name="produit[]">'+ produit_options +'</select></div></div></td>';
        e ='<td><div class="text-center"><div class="col-sm-12 cl-code"></div></div></td>';
        b = '<td><div class="form-group"><div class="col-sm-12"><input type="number" class="form-control cl_qte" name="qte[]" required=""><input type="hidden" class="cl_variation" name="variation[]"></div></div></td>';
        c = `
                <td class="td-montant">
                    <div class="form-group">
                      <div class="col-sm-12">
                      <select name="prix[]" class="cl_prix form-control" id="cl_prix">
                        <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </td>
        `;
        d = '<td class="td-montant"><div class="form-group"><div class="col-sm-12"><input type="number" class="form-control cl_total" name="total[]" readonly=""></div></div></td><td></td>'

        var markup = '<tr data-id="'+ new_id +'">' + a + e +  b + c + d + '</tr>';
        $("#table-commande-add tbody").append(markup);
        $('#id-row').val(new_id);

        $('.select2').select2();

        calculTotal();


    });

    $(document).on('click', '.btn-remove-row', function(event) {
        event.preventDefault();
        var produits = [];
        var isFind = false;

        var id     = Number($('#id-row').val());
        var new_id = id - 1;
        if (new_id >= 0) {
            $('#id-row').val(new_id);
            $('#table-commande-add tbody tr:last').remove();
        } else {
            show_info("Attention", 'Le tableau devrait contenir au moins une ligne','error');
        }
        calculTotal();

        $('table#table-commande-add > tbody  > tr').each(function(index, tr) { 
            var produitExist = $(tr).find('.cl_produit option:selected').val();
            if(produits.length > 0){
                if(checkValue(produitExist, produits)){ 
                    isFind = true;
                }  
            } 
            produits.push(produitExist);    
        });

        if(!isFind)
            $('#btn-save').removeClass('disabled');
    });

    $(document).on('input','.cl_qte',function (event) {
        var qte = event.target.value;
        var stock = $(this).attr('max');
        stock = Number(stock);
        qte = Number(qte);
        if(stock && qte){
            if(stock < qte) {
                // $('#btn-save').addClass('disabled');
                $(this).val('')
                return show_info("QUANTITÉ NON VALIDE", 'PAS ASSEZ DE STOCK','warning');
            }
        } 
        $('#btn-save').removeClass('disabled');
        var prix_selector = $(this).closest('tr').find('.cl_prix');
        var total_selector = $(this).closest('tr').find('.cl_total');

        if (qte) {
        	var total = Number( prix_selector.val() ) * Number( qte );
        } else {
        	var total = prix_selector.val();
        }

        total_selector.val( total );
        calculTotal()
    });

    $(document).on('change','.cl_prix',function (event) {

        var qte_selector = $(this).closest('tr').find('.cl_qte');
        var prix = event.target.value;
        var total_selector = $(this).closest('tr').find('.cl_total');
        $(this).closest('tr').find('.cl_variation').val($(this).find('option:selected').data("variation"))
        if (qte_selector.val()) {
        	var total = Number( qte_selector.val() ) * Number( prix );
        } else {
        	var total = 0;
        }
        
        total_selector.val( total );
        calculTotal()
    });

    var montant_total = 0;


    function calculTotal() {

        montant_total = 0;

        $('table#table-commande-add > tbody  > tr').each(function(index, tr) { 
           var montant_selector = $(this).find(".cl_total");

           var montant = montant_selector.val();

           montant_total += Number(montant);

           $('#montant_total').val(montant_total);
          
        });
    }

    $(document).on('click', '#btn-save', function(event) {
        event.preventDefault(); 

        negatif = false
        vide = false
        // $('.cl_produit').each(function(){
        //     var cl_qte = 
        // })
        $('.cl_qte').each(function(){
            if(parseInt($(this).val()) < 0){
                negatif = true ;
                return false
            }
            else if(!Number.isInteger(parseInt($(this).val())))
            {
                vide = true ;
                return false
            }
       })

        if(!negatif && !vide)
        {
            var produits = [];
            var isFind = false;

            $('table#table-commande-add > tbody  > tr').each(function(index, tr) { 
                var produitExist = $(tr).find('.cl_produit option:selected').val();
                if(produits.length > 0){
                    if(checkValue(produitExist, produits)){ 
                        isFind = true;
                    }  
                } 
                produits.push(produitExist);    
            });

            if(isFind) return;

            var data = $('#form-commande').serializeArray();

            var url = Routing.generate('caisse_vente_save');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(res) {
                    show_success('Succès', 'Achat éffectué');
                }
            })
        }
        else
        {
            if(negatif)
            {
                swal({
                    type: 'error',
                    title: "Quantité Negatif",
                    text: "Vérifier tous les quantités en produit de la facture ",
                    // footer: '<a href="">Misy olana be</a>'
                }) 
            }
            else if(vide)
            {
                swal({
                    type: 'warning',
                    title: "Quantité vide ou invalide",
                    text: "Remplissez ou corriger les quantités en produit de la facture ",
                    // footer: '<a href="">Misy olana be</a>'
                }) 
            }
        }
    })

});

function checkValue(value,arr){
  var status = false;
 
  for(var i=0; i<arr.length; i++){
    var name = arr[i];
    if(name == value){
      status = true;
      break;
    }
  }

  return status;
}