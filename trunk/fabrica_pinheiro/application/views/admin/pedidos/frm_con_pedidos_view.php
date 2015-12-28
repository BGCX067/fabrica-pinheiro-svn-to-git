<form name="frm_con_pedidos" id="frm_con_pedidos" action="{url_admin}pedidos/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="{nome}" />
    </div>

    <div style="float: left;">
        <label for="data_hora">Data</label>
        <input type="text" name="data_hora" id="data_hora" value="{data_hora}" class="data" />
    </div>

    <div style="float: left;">
        <label for="situacao">Situação</label>
        <select id="situacao" name="situacao">
            {situacao}
        </select>
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>