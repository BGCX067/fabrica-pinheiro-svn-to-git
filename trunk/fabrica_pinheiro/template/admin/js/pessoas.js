$(window).load(function(){
    
    tipo_pessoa($('#frm_cad_pessoas #tipo_pessoa').val());
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_cad_pessoas #tipo_pessoa').change(function(){
        tipo_pessoa($(this).val());
    });
    
    $('#frm_con_pessoas .bt_consultar').form_consultar();
    
    bt_novo();
    
    $('.bt_gravar').click(function(){
        if($('#frm_cad_pessoas').valida_form() == true){
            $.ajax({
                url: url_admin+'pessoas/gravar',
                dataType: 'json',
                data: $('#frm_cad_pessoas').serialize(),
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
                        $('#frm_cad_pessoas #id_pessoas').val(b.id_pessoas);
                    } else {
                        $('#frm_cad_pessoas').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
    $("#frm_cad_pessoas #cep").change(function(e){
        if($.trim($("#cep").val()) != ""){
            $.msg({
                rv:true
            }); 
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
                if(resultadoCEP["resultado"] == 1){
                    $("#endereco").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
                    $("#bairro").val(unescape(resultadoCEP["bairro"]));
                    $("#cidade").val(unescape(resultadoCEP["cidade"]));
                    $("#estado").val(unescape(resultadoCEP["uf"]));
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
    if($('#frm_cad_pessoas').html() != null){
        $('#frm_cad_pessoas #inscricao').removeClass('cpf');
        $('#frm_cad_pessoas #inscricao').removeClass('cnpj');
        $('#frm_cad_pessoas label[for="inscricao"]').html('');
        if(tipo == 'F'){
            $('#frm_cad_pessoas #inscricao').addClass('cpf');
            $('#frm_cad_pessoas label[for="inscricao"]').html('CPF');
        } else if (tipo == 'J'){
            $('#frm_cad_pessoas #inscricao').addClass('cnpj');
            $('#frm_cad_pessoas label[for="inscricao"]').html('CNPJ');
        } else {
            $('#frm_cad_pessoas #inscricao').addClass('cpf');
            $('#frm_cad_pessoas label[for="inscricao"]').html('CPF');
        }
        $('#frm_cad_pessoas').insere_mascara();
    }
}