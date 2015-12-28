<form name="frm_con_usuarios" id="frm_con_usuarios" action="{url_admin}usuarios/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="email">E-mail</label>
        <input type="text" name="email" id="email" value="{email}" />
    </div>

    <div style="float: left;">
        <label for="status">Status</label>
        <select id="status" name="status">
            {status}
        </select>
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>