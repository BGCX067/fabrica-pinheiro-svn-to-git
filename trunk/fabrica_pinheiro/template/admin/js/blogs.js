$(window).load(function(){
    
    $('#frm_cad_blogs').insere_mascara();

    $('#frm_cad_blogs #id_categorias').select2();
    $('#frm_cad_blogs #id_tags').select2({tags:[]});
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_con_blogs .bt_consultar').form_consultar();
   
    bt_novo();
     
    $('.bt_gravar').click(function(){
        if($('#frm_cad_blogs').valida_form() == true){
            $.ajax({
                url: url_admin+'blogs/gravar',
                dataType: 'json',
                data: $('#frm_cad_blogs').serialize(),
                type : 'POST',
                beforeSend: function() {
                    $.msg({
                        cs:'sucesso',
                        desc:'Aguarde... Validando dados.',
                        icon:'ui-icon-info'
                    });
                },
                success: function(b) {
                    if(b.cod == 999){
                        $.msg({
                            cs:'sucesso',
                            desc: b.msg,
                            icon:'ui-icon-info'
                        });   
                        $('#frm_cad_blogs #id_blogs').val(b.id_blogs);
                    } else {
                        $('#frm_cad_blogs').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});