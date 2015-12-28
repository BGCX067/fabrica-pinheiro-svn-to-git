<form name="frm_con_pessoas" id="frm_con_pessoas" action="{url_admin}pessoas/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="{nome}" />
    </div>

    <div style="float: left;">
        <label for="tipo_pessoa">Tipo de Pessoa</label>
        <select id="tipo_pessoa" name="tipo_pessoa">
            {tipo_pessoa}
        </select>
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>