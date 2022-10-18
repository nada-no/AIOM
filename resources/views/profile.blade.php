@extends('layouts.lateral')

@section('content')

<div class="container mt-5">
    <h2>Edita tu perfil</h2>
    <div class="content h-75 mb-4">
    <form class="form-horizontal" method="post" action={{ route('updateAccount') }} enctype="multipart/form-data">
    @csrf
    <div class="form-group">
            <label class="control-label col-sm-2" for="image">Imagen de perfil:</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="cover" id="image">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Nickname:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nick" id="nick" placeholder="Introduce tu nombre">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="password">Cambiar password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="password" placeholder="Nueva password">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="password2">Repite la nueva password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Repite la password">
            </div>
        </div>
        <input type="submit" class="btn btn-primary text-white" value="Guardar cambios">
    </form>
    <br>
    {{-- <form method="post" action={{ route('deleteAccount') }}>
        @csrf
            <input type="submit" class="btn btn-primary text-white" value="Eliminar cuenta">
    </form> --}}
    </div>
    <div class="footer">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (isset($success))
            @if ($success)
            <div class="alert alert-success">
                <ul class="list-unstyled">
                    <li>Se ha subido con exito.</li>
                </ul>
            </div>
            @else
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    <li>No se ha podido guardar los cambios del perfil.</li>
                </ul>
            </div>
            @endif
        @endif
        </div>
</div>



@endsection