@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">
                <a href="#">{{$thread->creator->name}}</a>:
                    {{ $thread->title }}
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    <br>
    @if (auth()->check())

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ $thread->path() . '/replies' }}" method="post">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                       
                        <textarea name="body" id="body" class="form-control" 
                        placeholder="tienes algo que decir?" rows="4"></textarea>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>
    
    @else
        <p class="text-center">
            <a href="{{ route('login') }}">Ingresa</a> a tu cuenta para participar en esta discusión
        </p>
    @endif



</div>
@endsection
