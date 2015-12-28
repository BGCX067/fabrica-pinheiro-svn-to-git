<form name="frm_con_categorias" id="frm_con_categorias" action="{url_admin}categorias/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" value="{descricao}" />
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>