@extends('layout', [
    'title' => 'Redirects',
])

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Redirects</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('redirects.create') }}"> Novo Redirect</a>
            </div>
        </div>
    </div>

    @if (session()->get('message'))
        <div class="alert alert-success">
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Código</th>
            <th>Status</th>
            <th>URL de destino</th>
            <th>Último acesso</th>
            <th>Data de criação</th>
            <th>Data de atualização</th>
            <th width="280px">Ações</th>
        </tr>
        @foreach ($redirects as $redirect)
            <tr>
                <td>{{ $redirect->code }}</td>
                <td>{{ $redirect->status === 1 ? 'Ativo' : 'Inativo' }}</td>
                <td>{{ $redirect->url_redirect }}</td>
                <td>{{ $redirect->logs ? $redirect->logs->max('accessed_at') : '' }}</td>
                <td>{{ $redirect->created_at }}</td>
                <td>{{ $redirect->updated_at }}</td>
                <td>
                    <form action="{{ route('redirects.destroy', $redirect->code) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('r.redirect', $redirect->code) }}" target="_blank">Abrir</a>

                        <a class="btn btn-primary" href="{{ route('redirects.edit', $redirect->code) }}">Editar</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $redirects->links('pagination::bootstrap-4') !!}

@endsection
