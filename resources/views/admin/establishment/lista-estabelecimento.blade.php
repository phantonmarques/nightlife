@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
    <h1>Histórico de Movimentações</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Histórico</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <form action="#" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <input type="text" name="id" class="form-control" placeholder="ID">
                <input type="date" name="date" class="form-control" >
                <select name="type" class="form-control">
                    <option value="">--- SELECIONE O TIPO ---</option>
{{--                    @foreach($types as $key => $type)--}}
{{--                        <option value="{{ $key }}">{{ $type }}</option>--}}
{{--                    @endforeach--}}
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID Usuário</th>
                    <th>ID Estabelecimento</th>
                    <th>Razão Social</th>
                    <th>Nome Fantasia</th>
                    <th>Inscrição Estadual</th>
                    <th>Tipo Licença</th>
                    <th>E-mail</th>
                    <th>Login</th>
                    <th>CNPJ</th>
                    <th>Contato</th>
                    <th>Celular</th>
                    <th>CEP</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($userEstab) && isset($estab))
                    <tr>
                        <td>{{ $estab->user_id }}                                       </td>
                        <td>{{ $estab->id }}                                            </td>
                        <td>{{ $estab->corporate_name }}                                </td>
                        <td>{{ $userEstab->name }}                                      </td>
                        <td>{{ $estab->state_registration }}                            </td>
                        <td>{{ ($estab->type_license === 'b') ? 'Básica' : 'Full' }}    </td>
                        <td>{{ $userEstab->email }}                                     </td>
                        <td>{{ $userEstab->login }}                                     </td>
                        <td>{{ $userEstab->cpf_cnpj }}                                  </td>
                        <td>{{ $userEstab->contact_main }}                              </td>
                        <td>{{ '('.$userEstab->ddd_main.')'.$userEstab->phone_main }}   </td>
                        <td>{{ $estab->zip_code }}                                      </td>
                    </tr>
                @elseif (isset($estabelecimentos))
                    @foreach($estabelecimentos as $estab)
                        @php
                                var_dump($estab);
                        die();
                                @endphp
                        <tr>
                            <td>{{ $estab->user_id }}                                       </td>
                            <td>{{ $estab->id }}                                            </td>
                            <td>{{ $estab->corporate_name }}                                </td>
                            <td>{{ $estab->name }}                                      </td>
                            <td>{{ $estab->state_registration }}                            </td>
                            <td>{{ ($estab->type_license === 'b') ? 'Básica' : 'Full' }}    </td>
                            <td>{{ $estab->email }}                                     </td>
                            <td>{{ $estab->login }}                                     </td>
                            <td>{{ $estab->cpf_cnpj }}                                  </td>
                            <td>{{ $estab->contact_main }}                              </td>
                            <td>{{ '('.$estab->ddd_main.')'.$estab->phone_main }}   </td>
                            <td>{{ $estab->zip_code }}                                      </td>
                        </tr>
                    @endforeach
                @endif
{{--                'estab', 'usuario'--}}
{{--                @forelse($historics as $historic)--}}
{{--                    <tr>--}}
{{--                        <td>{{ $historic->id }}</td>--}}
{{--                        <td>{{ number_format($historic->amount,2,',','.') }}</td>--}}
{{--                        <td>{{ $historic->type($historic->type) }}</td>--}}
{{--                        <td>{{ $historic->date }}</td>--}}
{{--                        <td>@if ($historic->user_id_transaction)--}}
{{--                                {{ $historic->userSender->name }}--}}
{{--                            @else--}}
{{--                                ---}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @empty--}}
{{--                @endforelse--}}
                </tbody>
            </table>

{{--            @if (isset($dataForm))--}}
{{--                {!! $historics->appends($dataForm)->links() !!}--}}
{{--            @else--}}
{{--                {!! $historics->links() !!}--}}
{{--            @endif--}}
        </div>
    </div>
@stop