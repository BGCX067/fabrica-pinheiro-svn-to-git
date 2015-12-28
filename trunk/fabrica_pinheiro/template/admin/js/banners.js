$(window).load(function(){
    
    $('#frm_cad_banners').insere_mascara();
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_con_banners .bt_consultar').form_consultar();
    
    bt_novo();
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_banners').valida_form() == true){
            $.ajax({
                url: url_admin+'banners/gravar',
                dataType: 'json',
                data: $('#frm_cad_banners').serialize(),
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
                        $('#frm_cad_banners #id_banners').val(b.id_banners);
                    } else {
                        $('#frm_cad_banners').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
    if($('#frm_cad_banners #id_banners_tipos').val() == ""){
        ocultar_div_upload();
    }
    
    $('#frm_cad_banners #id_banners_tipos').change(function(){
        if($(this).val() == ""){
            ocultar_div_upload();
        } else {
            $('#frm_cad_banners #path').val('');
            $('.fotos').html('');
            var obj = this;
            $('#bt_fotos').upload_arquivos({
                nome_botao: 'Adicionar Banner',
                url: url_admin+'banners/upload_banner',
                debug_display: false,
                data: {
                    'id_banners_tipos' : $(obj).val()
                },
                success: function(b) {
                    $('#frm_cad_banners #path').val('');
                    $('.fotos').html('');
                    $.msg({
                        rv:true
                    }); 
                    if(b.cod == 999){
                        var arquivo = '';
                        if(b.mimeTipo == 'image'){
                            arquivo = '<img src="'+url_base+'banners/'+b.name+'" width="'+b.largura+'px" height="'+b.altura+'px" title="'+b.name+'" />';
                            $('.fotos').html(arquivo);
                        } else {
                            $('.fotos').flash({
                                src: url_base+'banners/'+b.name,
                                width: b.largura,
                                height: b.altura
                            });
                        }
                        $('#frm_cad_banners #path').val(b.name);
                        
                    } else {
                        var msg = '';
                        $.each(b.erros,function(y,z){
                            if(y != 'cod'){
                                if(msg != ''){
                                    msg += '<br />';
                                }
                                msg += z;
                            }
                        });
                        $.msg({
                            cs:'erro',
                            desc: msg,
                            icon:'ui-icon-alert'
                        });   
                    }
                },
                error: function(a) {
                    $.msg({
                        cs:'erro',
                        desc: a.msg,
                        icon:'ui-icon-alert'
                    });  
                }
            });
    
            $('#bt_fotos').show();
        }
    });
    
});

function ocultar_div_upload(){
    $('#bt_fotos').hide();
}