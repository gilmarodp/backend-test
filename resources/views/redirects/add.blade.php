@extends('layout', [
    'title' => 'Editar Redirect',
])

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Adicionar Redirect</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('redirects.index') }}"> Voltar</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ocorreram alguns erros.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('redirects.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="url_redirect">URL de destino:</label>
                    <input
                        type="text"
                        id="url_redirect"
                        name="url_redirect"
                        value="{{ old('url_redirect') }}"
                        class="form-control"
                        placeholder="URL de destino"
                    >
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </form>
@endsection
