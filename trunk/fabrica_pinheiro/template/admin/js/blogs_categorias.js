$(window).load(function(){
    
    $('#frm_cad_blogs_categorias').insere_mascara();
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_con_blogs_categorias .bt_consultar').form_consultar();
    
    bt_novo();
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_blogs_categorias').valida_form() == true){
            $.ajax({
                url: url_admin+'blogs_categorias/gravar',
                dataType: 'json',
                data: $('#frm_cad_blogs_categorias').serialize(),
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
                        $('#frm_cad_blogs_categorias #id_blogs_categorias').val(b.id_blogs_categorias);
                    } else {
                        $('#frm_cad_blogs_categorias').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});