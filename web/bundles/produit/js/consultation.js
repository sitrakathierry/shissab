var cl_row_edited = 'r-cl-edited';

$(document).ready(function(){

    $('.select2').select2();

	load_list();

	function instance_grid() {
        var colNames = ['Code produit','Catégorie','Nom', 'Stock', ''];
        
        var colModel = [
        // { 
        //     name:'qrcode',
        //     index:'qrcode',
        //     align: 'center' ,
        //     formatter: function(v) {
        //     	return '<img style="width: 50px;padding: 5px;" src="'+ v +'">';
        //     }
        // }
        // ,{ 
        //     name:'image',
        //     index:'image',
        //     align: 'center' ,
        //     formatter: function(v) {
        //         var src = v;

        //         if (v == '') {
        //             src = get_picture_b64();
        //         }
        //         return '<img style="width: 100px;padding: 5px;" src="'+ src +'">';
        //     }
        // },
        { 
            name:'code_produit',
            index:'code_produit',
            // align: 'center' 
        },{ 
            name:'categorie',
            index:'categorie',
            // align: 'center' 
        },{ 
            name:'nom',
            index:'nom',
            // align: 'center' 
        },{ 
            name:'stock',
            index:'stock',
            // align: 'center'
        },{
            name:'action',
            index:'action',
            align: 'center',
            formatter: function(v){ 
                return '<button class="btn btn-xs btn-outline btn-primary afficher " data-type="0"><i class="fa fa-pencil-square-o "></i>&nbsp;Afficher'; 
            }
        }];

        var options = {
            datatype   : 'local',
            height     : 300,
            autowidth  : true,
            loadonce   : true,
            shrinkToFit: true,
            rownumbers : false,
            altRows    : false,
            colNames   : colNames,
            colModel   : colModel,
            viewrecords: true,
            hidegrid   : true,
            forceFit:true,
            rowNum: 1000000000
        };

        var tableau_grid = $('#liste_produit');

        if (tableau_grid[0].grid == undefined) {
            tableau_grid.jqGrid(options);
        } else {
            delete tableau_grid;
            $('#liste_produit').GridUnload('#liste_produit');
            tableau_grid = $('#liste_produit');
            tableau_grid.jqGrid(options);
        }

        var window_height = window.innerHeight - 600;

        if (window_height < 300) {
            tableau_grid.jqGrid('setGridHeight', 300);
        } else {
            tableau_grid.jqGrid('setGridHeight', window_height);
        }

        return tableau_grid;
    }

    function load_list() {
    	
        var url = Routing.generate('produit_list'); 
        var data = {
        	agence : $('#agence').val(),
            recherche_par: $('#recherche_par').val(),
            a_rechercher: $('#a_rechercher').val(),
            categorie: $('#categorie').val(),
            produit_id: $('#produit_id').val(),
        };

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'html',
            async: true,
            success: function(res) {
                // console.log(res) ;
                var grid = instance_grid();
                grid.jqGrid('setGridParam', {
                    data        : $.parseJSON(res),
                    loadComplete: function() {
                    }
                }).trigger('reloadGrid', [{
                    page: 1,
                    current: true
                }]);
            }

        })
    
    }


	$(document).on('click', '.afficher', function(){
        var id = $(this).hasClass('cl_add') ? 0 : $(this).closest('tr').attr('id'),
            action = parseInt($(this).attr('data-type'));

        $('.'+cl_row_edited).removeClass(cl_row_edited);

        if (id !== 0) $(this).closest('tr').addClass(cl_row_edited);

        window.location.href = Routing.generate('produit_show', { id : id })
    });

    $(document).on('click', '#btn_search', function(event) {
        event.preventDefault();

        load_list();
    });

    $(document).on('change', '#produit_id', function(event) {
        event.preventDefault();

        load_list();
    });

    // $(document).on( "keydown", function( event ) {
    //     console.log(event)
    //   if (event.which === 13) {
    //     load_list();
    //   }
    // });

});