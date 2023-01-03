@extends('layouts.app')

@section('content')

<div class="container">


        <h2>Popular events in Tübingen</h2>


        @foreach($events as $event)
        
            <div class="card mb-5">
                <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="/organizer-profile/{{$event->organizer->profile->id}}">
                                <div class="pe-3">
                                    <img src="{{$event->organizer->profile->profileImage()}}" class="w-100 rounded-circle img-thumbnail" style="max-width: 45px">
                                </div>
                            </a>
                            <div class="fw-bold">
                                <a href="/organizer-profile/{{$event->organizer->profile->id}}" class="text-decoration-none">
                                    <span class="text-dark">{{$event->organizer->name}}</span>
                                </a>
                            </div>
                        </div>
                </div>
                <a href="/event/{{$event->id}}" class="text-decoration-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <img src="{{$event->image()}}">
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <span class="h4 text-dark">{{ $event->title}} </span>
                                <span class="text-dark" >{{ $event->shortDescription()}}...</span>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                       <li><span class="text-dark">When? {{$event->date}}</span></li> 
                                       <li><span class="text-dark">Where? {{$event->city}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                </a>
            </div>
        @endforeach


 </div>
    


@endsection
