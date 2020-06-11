<table>
    <thead>
        <tr>
            <th>Nome Fantasia</th>
            <th>Razão Social</th>
            <th>Usuário Vinculado</th>
            <th>E-mail</th>
            <th>Inscrição Estadual</th>
            <th>Tipo Licença</th>
            <th>Descrição</th>
            <th>Data Criação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($establishment as $e)
                <td>{{ $e->corporate_name }}</td>
                <td>{{ $e->company_name }}</td>
                <td>{{ $e->users->name }}</td>
                <td>{{ $e->users->email }}</td>
                <td>{{ $e->state_registration }}</td>
                <td>{{ ($e->type_license === 'b') ? 'Básica' : 'Completa' }}</td>
                <td>{{ $e->details }}</td>
                <td>{{ formatDateHour($e->created_at) }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Author</th>
            <th>Nota</th>
            <th>Data/Hora</th>
        </tr>
    </thead>
    <tbody>
    @foreach($ratings as $rating)
        <tr>
            <td>{{ $rating->author }}</td>
            <td>{{ $rating->rating }}</td>
            <td>{{ formatDateHour($rating->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Author</th>
            <th>Comentário</th>
            <th>Data/Hora</th>
        </tr>
    </thead>
    <tbody>
    @foreach($comments as $comment)
        <tr>
            <td>{{ $comment->author }}</td>
            <td>{{ $comment->comment }}</td>
            <td>{{ formatDateHour($comment->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>