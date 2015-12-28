<form name="frm_con_banners" id="frm_con_banners" action="{url_admin}banners/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" value="{descricao}" />
    </div>

    <div style="float: left;">
        <label for="link">Link</label>
        <input type="text" name="link" id="link" value="{link}" />
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>