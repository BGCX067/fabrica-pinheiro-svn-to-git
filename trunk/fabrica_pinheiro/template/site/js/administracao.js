$(window).load(function(){
    
    $('#frm_login .bt_logar').bt({
        text:'Entrar',
        icon:'ui-icon-disk'
    });
    
    $('#frm_login .bt_logar').click(function(){
        if($('#frm_login').valida_form() == true){
            $.ajax({
                url: url_site+'administracao/logar',
                dataType: 'json',
                data: {
                    'email':$('#frm_login #email').val(),
                    'senha':md5($('#frm_login #senha').val())
                },
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
                        location.href = b.link;
                    } else if(b.cod == 222){
                        $.msg({
                            cs:'sucesso',
                            desc: b.msg,
                            icon:'ui-icon-info'
                        });   
                    } else {
                        $('#frm_login').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
});