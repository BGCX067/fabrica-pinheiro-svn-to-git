<div class="paginacao">{paginacao}</div>
<table class="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        {clientes}
        <tr>
            <td>{id_clientes}</td>
            <td>{nome}</td>
            <td>{email}</td>
            <td>{status}</td>
            <td>{acao}</td>
        </tr>
        {/clientes}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>