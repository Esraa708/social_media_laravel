@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{route('friendposts') }}" method="get">
        <div class=" row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="search" class="t">select a user</label>
                    <select name="userId" id="search" class="form-control">
                        @foreach ($friends as $friend)
                        @if(Session::get('selectedUser') == $friend->id)
                        <option value={{$friend->id}} selected>{{$friend->name}}</option>
                        @else
                        <option value={{$friend->id}}>{{$friend->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="submit" value="send" class="btn send mt-3">
                </div>


            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-8">
            @if(session()->get('posts'))
            @foreach (session()->get('posts') as $post)
            <x-post :post="$post" />
            @endforeach
            @endif
        </div>
    </div>

    <div class="d-flex flex-column align-items-center justifiy-content-center">
        @if(session()->get( 'posts' ))
        {{ session()->get( 'posts' )->appends(['userId' => Session::get('selectedUser')])->links()}}
        @endif
    </div>
</div>

@endsection