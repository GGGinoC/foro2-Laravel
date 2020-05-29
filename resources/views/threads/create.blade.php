@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crea una nueva discusión</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        {{ csrf_field() }} 

                        <div class="form-group">
                            <label for="channel_id">Escoje un Canal:</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Escoje...</option>
                                @foreach (App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Titulo:</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" required>
                        </div>

                        <div class="form-group">
                            <label for="body">Cuerpo:</label>
                        <textarea name="body" class="form-control" id="body" rows="8" required>{{old('body')}}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publicar</button>
                        </div>        
                    </form>
                    @if (count($errors))
                        @foreach ($errors->all() as $error)
                            <ul class="alert alert-danger">
                                <li>{{$error}}</li>
                            </ul>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
