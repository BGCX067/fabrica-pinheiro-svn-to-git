<div class="paginacao">{paginacao}</div>
<table class="tabela">
    <thead>
        <tr>
            <th class="cols05">ID</th>
            <th class="cols10">Data/Hora</th>
            <th class="cols15">Situação</th>
            <th class="cols15">Nome</th>
            <th class="cols20">E-mail</th>
            <th class="cols10">Cidade</th>
            <th class="cols10">Bairro</th>
            <th class="cols05">Total</th>
            <th class="cols10">Ação</th>
        </tr>
    </thead>
    <tbody>
        {pedidos}
        <tr>
            <td>{id_pedidos}</td>
            <td>{data_hora}</td>
            <td>{situacao}</td>
            <td>{nome}</td>
            <td>{email}</td>
            <td>{cidade}</td>
            <td>{bairro}</td>
            <td>{total}</td>
            <td>{acao}</td>
        </tr>
        {/pedidos}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>