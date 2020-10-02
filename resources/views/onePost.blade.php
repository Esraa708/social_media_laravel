@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-1 col-md-7">
            <!-- <single-post :postData='@json($post)' :userData='@json(Auth::user())'>
                
            </single-post> -->
            <x-post :post=$post />
            <div class="comment mt-0">
                <form action="/comment" method="post">
                    @csrf
                    <input type="text" name="content" class="form-control" placeholder="Enter a comment" />
                    <input type="hidden" name="id" value="{{$post->id}}">
                    <button type="submit" class="btn btn-info">
                        comment
                    </button>
                </form>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="offset-1 c col-md-7">
            <h2>Comments</h2>
            @foreach ($comments as $comment)
            <x-comment :comment="$comment" />
            @endforeach
        </div>
    </div>
</div>
@endsection