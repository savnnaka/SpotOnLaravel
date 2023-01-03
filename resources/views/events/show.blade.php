@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="{{ $event->image() }}" class="w-100" style="width: 100px height: 100px" >
            <div class="d-flex align-items-center float-end mt-2">
                @if(Auth::guard('web')->check())
                <form action="/likes/{{ $event->id }}" method="post">
                    @csrf
                    <button class="btn btn-primary">{{ $like }}</button>
                </form>
                @endif
                <span class="ms-2"><i class="fa fa-heart" style="color: rgb(137, 5, 5);"></i> {{ $likesCount}}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="card">

                {{-- @can('update', $event)
                <a href="/event/{{$event->id}}/edit">Edit</a>
                @endcan --}}
                
                @if(Auth::guard('organizer')->check())
                
                @if(Auth::guard('organizer')->user()->id == $event->organizer_id)
                <a href="/event/{{$event->id}}/edit" class="btn btn-secondary">Edit Event</a>
                @endif
                
                @endif

                <div class="card-header">
                    <h4>{{ $event->title}}</h4>
                </div>
                <div class="card-body">
                    <div>
                        <span class="fw-bold"> Date and Time </span>
                        <p>{{ date('m/d/y, h:m', strtotime($event->date)) }}</p>
                    </div>
                    <div>
                        <span class="fw-bold"> City </span>
                        <p>{{ $event->city }}</p>
                    </div>
                    <div>
                        <span class="fw-bold"> Organizer </span>
                        <div class="d-flex align-items-center">
                            <a href="/organizer-profile/{{$event->organizer->profile->id}}">
                                <div class="pe-3">
                                    <img src="{{$event->organizer->profile->profileImage()}}" class="w-100 rounded-circle" style="max-width: 45px">
                                </div>
                            </a>
                            <div class="fw-bold">
                                <a href="/organizer-profile/{{$event->organizer->profile->id}}" class="text-decoration-none">
                                    <span class="text-dark">{{$event->organizer->name}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row pt-5">
        <div class="col-8">
            <div>
                <h2>About this event</h2>
            </div>
            <div>
                {!! $event->description !!}
            </div>
        </div>
        <div class="col-4">
            <div>
                <h2>About organizer</h2>
                <p> {{ $event->organizer->profile->description }}</p>
            </div>

        </div>
    </div>

    <div class="comment-section">
        <h2>Comments</h2>
        @foreach($comments as $comment)
            
            @if($toEdit == $comment->id)

            <div class="card">
                <div class="card-header">
                    Edit what you wrote on {{ $comment->created_at }}
                </div>
                <div class="card-body">
                    <form action="/comment/{{$comment->id}}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="event_id" value="{{ $event->id }}"/>
                        <textarea name="content" cols="60" rows="5">{{ $comment->content }}</textarea>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            
            @else
                <div class="card mt-2">
                    <div class="card-header">
                        {{ $comment->user->name }} wrote on {{ $comment->created_at }}
                        @can('update', $comment)
                            
                            <form action="/comment/{{$comment->id}}" method="POST" class="float-end">
                            @csrf
                            @method("DELETE")
                            <a class="btn btn-info" href="/comment/{{$comment->id}}/edit">Edit</a>
                            <input type="hidden" name="event_id" value="{{$event->id}}">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                        @endcan
                    </div>
                    <div class="card-body">
                        {{ $comment->content }}
                    </div>
                </div>
            @endif
        @endforeach

        @if(Auth::guard('web')->check())
        <div class="mt-4">
            <h4>Add comment</h4>
            <form action="/comment" method="post">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}"/>
                <textarea name="content" rows="4" cols="50"></textarea><br>
                <button class="btn btn-primary ">Submit</button>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection

