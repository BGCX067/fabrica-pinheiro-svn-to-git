$(window).load(function(){
    
    $('#frm_login .bt_logar').bt({
        text:'Entrar',
        icon:'ui-icon-disk'
    });
    
    $('#frm_cad_clientes .bt_gravar').bt({
        text:'Entrar',
        icon:'ui-icon-disk'
    });
    
    tipo_pessoa($('#frm_cad_clientes #tipo_pessoa').val());
   
    $('#frm_cad_clientes #tipo_pessoa').change(function(){
        tipo_pessoa($(this).val());
    });
    
    $('#frm_login .bt_logar').click(function(){
        if($('#frm_login').valida_form() == true){
            $.ajax({
                url: url_site+'login/logar',
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
    
    $('#frm_cad_clientes .bt_gravar').click(function(){
        if($('#frm_cad_clientes').valida_form() == true){
            $.ajax({
                url: url_site+'login/gravar',
                dataType: 'json',
                data: {
                    'id_pessoas':$('#frm_cad_clientes #id_pessoas').val(),
                    'id_clientes':$('#frm_cad_clientes #id_clientes').val(),
                    'nome':$('#frm_cad_clientes #nome').val(),
                    'tipo_pessoa':$('#frm_cad_clientes #tipo_pessoa').val(),
                    'endereco':$('#frm_cad_clientes #endereco').val(),
                    'numero':$('#frm_cad_clientes #numero').val(),
                    'complemento':$('#frm_cad_clientes #complemento').val(),
                    'bairro':$('#frm_cad_clientes #bairro').val(),
                    'cidade':$('#frm_cad_clientes #cidade').val(),
                    'estado':$('#frm_cad_clientes #estado').val(),
                    'cep':$('#frm_cad_clientes #cep').val(),
                    'inscricao':$('#frm_cad_clientes #inscricao').val(),
                    'telefone':$('#frm_cad_clientes #telefone').val(),
                    'celular':$('#frm_cad_clientes #celular').val(),
                    'email':$('#frm_cad_clientes #email').val(),
                    'senha':md5($('#frm_cad_clientes #senha').val())
                },
                type : 'POST',
                beforeSend: function() {
                    $.msg({
                        cs:'sucesso',
                        desc:'Aguarde... Criando novo cliente.',
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
                        $('#frm_cad_clientes').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
    $("#frm_cad_clientes #cep").change(function(e){
        if($.trim($("#cep").val()) != ""){
            $.msg({
                rv:true
            }); 
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
                if(resultadoCEP["resultado"] == 1){
                    $("#frm_cad_clientes #endereco").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
                    $("#frm_cad_clientes #bairro").val(unescape(resultadoCEP["bairro"]));
                    $("#frm_cad_clientes #cidade").val(unescape(resultadoCEP["cidade"]));
                    $("#frm_cad_clientes #estado").val(unescape(resultadoCEP["uf"]));
                }else{
                    $.msg({
                        cs:'erro',
                        desc: "Não foi possivel encontrar o endereço",
                        icon:'ui-icon-alert'
                    }); 
                }
            });
        }
    });
    
});
function tipo_pessoa(tipo){
    if($('#frm_cad_clientes').html() != null){
        $('#frm_cad_clientes #inscricao').removeClass('cpf');
        $('#frm_cad_clientes #inscricao').removeClass('cnpj');
        $('#frm_cad_clientes label[for="inscricao"]').html('');
        if(tipo == 'F'){
            $('#frm_cad_clientes #inscricao').addClass('cpf');
            $('#frm_cad_clientes label[for="inscricao"]').html('CPF');
        } else if (tipo == 'J'){
            $('#frm_cad_clientes #inscricao').addClass('cnpj');
            $('#frm_cad_clientes label[for="inscricao"]').html('CNPJ');
        } else {
            $('#frm_cad_clientes #inscricao').addClass('cpf');
            $('#frm_cad_clientes label[for="inscricao"]').html('CPF');
        }
        $('#frm_cad_clientes').insere_mascara();
    }
}