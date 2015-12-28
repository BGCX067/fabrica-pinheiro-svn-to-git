$(window).load(function(){
    
    $('#frm_cad_categorias').insere_mascara();
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_con_categorias .bt_consultar').form_consultar();
    
    bt_novo();
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_categorias').valida_form() == true){
            $.ajax({
                url: url_admin+'categorias/gravar',
                dataType: 'json',
                data: $('#frm_cad_categorias').serialize(),
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
                        $('#frm_cad_categorias #id_categorias').val(b.id_categorias);
                    } else {
                        $('#frm_cad_categorias').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});