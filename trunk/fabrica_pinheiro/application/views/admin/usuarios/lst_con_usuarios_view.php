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
        {usuarios}
        <tr>
            <td>{id_usuarios}</td>
            <td>{nome}</td>
            <td>{email}</td>
            <td>{status}</td>
            <td>{acao}</td>
        </tr>
        {/usuarios}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>