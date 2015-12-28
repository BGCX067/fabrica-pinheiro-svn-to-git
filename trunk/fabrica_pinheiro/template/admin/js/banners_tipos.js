$(window).load(function(){
    
    $('#frm_cad_banners_tipos').insere_mascara();
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_con_banners_tipos .bt_consultar').form_consultar();
    
    bt_novo();
    
    $('#frm_cad_banners_tipos #extensao').subtitulo("Extensões separadas por | '\"Pipeline\"' <br /> Exemplo: jpg|png|gif");
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_banners_tipos').valida_form() == true){
            $.ajax({
                url: url_admin+'banners_tipos/gravar',
                dataType: 'json',
                data: $('#frm_cad_banners_tipos').serialize(),
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
                        $('#frm_cad_banners_tipos #id_banners_tipos').val(b.id_banners_tipos);
                    } else {
                        $('#frm_cad_banners_tipos').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});