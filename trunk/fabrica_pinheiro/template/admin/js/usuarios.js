$(window).load(function(){
    
    $('#frm_cad_usuarios').insere_mascara();
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    if($('#frm_cad_usuarios #id_usuarios').val() == ''){
        $('#frm_cad_usuarios #senha').addClass('obrigatorio');
    }
    
    $('#frm_con_usuarios .bt_consultar').form_consultar();
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_usuarios').valida_form() == true){
            $.ajax({
                url: url_admin+'usuarios/gravar',
                dataType: 'json',
                data: $('#frm_cad_usuarios').serialize(),
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
                        $('#frm_cad_usuarios #id_usuarios').val(b.id_usuarios);
                    } else if(b.cod == 222){
                        $.msg({
                            cs:'erro',
                            desc: b.msg,
                            icon:'ui-icon-alert'
                        });   
                    } else {
                        $('#frm_cad_usuarios').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});