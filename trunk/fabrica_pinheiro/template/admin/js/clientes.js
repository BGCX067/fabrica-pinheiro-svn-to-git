$(window).load(function(){
    
    $('#frm_cad_clientes').insere_mascara();
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    if($('#frm_cad_clientes #id_clientes').val() == ''){
        $('#frm_cad_clientes #senha').addClass('obrigatorio');
    }
    
    $('#frm_con_clientes .bt_consultar').form_consultar();
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_clientes').valida_form() == true){
            $.ajax({
                url: url_admin+'clientes/gravar',
                dataType: 'json',
                data: $('#frm_cad_clientes').serialize(),
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
                        $('#frm_cad_clientes #id_clientes').val(b.id_clientes);
                    } else if(b.cod == 222){
                        $.msg({
                            cs:'erro',
                            desc: b.msg,
                            icon:'ui-icon-alert'
                        });   
                    } else {
                        $('#frm_cad_clientes').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});