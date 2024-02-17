@extends('layout', [
    'title' => 'Editar Redirect',
])

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Redirect</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('redirects.index') }}"> Voltar</a>
            </div>
        </div>
    </div>

    @if (session()->get('message'))
        <div class="alert alert-success">
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif

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

    <form action="{{ route('redirects.update', $redirect->code) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="url_redirect">URL de destino:</label>
                    <input
                        type="text"
                        id="url_redirect"
                        name="url_redirect"
                        value="{{ old('url_redirect', $redirect->url_redirect) }}"
                        class="form-control"
                        placeholder="URL de destino"
                    >
                </div>
            </div>
            <div class="col-xs-4 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1" {{ old('status', $redirect->status) == 1 ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ old('status', $redirect->status) == 1 ? '' : 'selected' }}>Inativo</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </form>
@endsection
