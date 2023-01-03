@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div  class="d-flex align-items-center pb-4">
            <img src="{{ $organizerProfile->profileImage() }}" class="w-100 rounded-circle" style="max-width: 100px">
            <h1 class="ps-4 pe-4">{{ $organizerProfile->name }}</h1>
            @if(Auth::guard('organizer')->check())
                @if(Auth::guard('organizer')->user()->id == $organizerProfile->organizer_id)
                <a href="/organizer-profile/{{$organizerProfile->id}}/edit" class="btn btn-secondary float-end">Edit Profile</a>
                @endif
            @endif
            @if(Auth::guard('web')->check())
            <form action="/follow/{{ $organizerProfile->organizer_id }}" method="post">
                @csrf
                <button class="btn btn-primary">{{$follows}}</button>
            </form>
            @endif
            <span class="ms-2">{{ $followerCount }} Follower</span>
        </div>

        @can('update', $organizerProfile)
        <a href="/organizer-profile/{{ $organizerProfile->id}}/edit" class="btn btn-light ps-15">edit profile</a>
        @endcan
    </div>


    <div class="row">

        <div class="col-3">   
            <h2>Contact</h2>    
            @if($organizerProfile->contact)
                <div>
                    <p> {{ $organizerProfile->contact }} </p>
                </div>
            @endif
        </div>
    
        <div class="col-9">
            <h2>About</h2>
            @if( $organizerProfile->description )
            <div>
                <p>{{ $organizerProfile->description }}</p>
            </div>
            @endif
        </div>

    </div>

    <hr>

    <div class="row pt-2 mb-2">
        <h2>Future events by {{$organizerProfile->organizer->name }} </h2>
        @foreach($organizerProfile->organizer->futureEvents as $event)
        <div class="card m-3" style="width: 18rem;">
            <div class="card-header">
                <p>{{date('m/d/y, h:m', strtotime($event->date))}}</p>
                <a href="/event/{{ $event->id }}" class="text-decoration-none">
                    <span class="h3 text-dark">{{$event->title }}</span>
                </a>
            </div>
            <div class="card-body">
                <a href="/event/{{ $event->id }}">
                    <img src="{{ $event->image() }}" class="w-100">
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row pt-2 mt-5">
        <h2>Past events by {{$organizerProfile->organizer->name }} </h2>
        @foreach($organizerProfile->organizer->pastEvents as $event)
        <div class="card m-3" style="width: 18rem;">
            <div class="card-header">
                <p>{{date('m/d/y, h:m', strtotime($event->date))}}</p>
                <a href="/event/{{ $event->id }}" class="text-decoration-none">
                    <span class="h3 text-dark">{{$event->title }}</span>
                </a>
            </div>
            <div class="card-body">
                <a href="/event/{{ $event->id }}">
                    <img src="{{ $event->image() }}" class="w-100">
                </a>
            </div>
        </div>

        @endforeach
    </div>


       
@endsection