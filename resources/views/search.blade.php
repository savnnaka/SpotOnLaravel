@extends('layouts.app')

@section('content')

<div class="container">
    <div>
        <h1>Find events</h1>
        <form method="GET" action="/search/" class="d-flex mb-5">
            @csrf
            <input type="search" name="search" class="form-control me-1" value="{{$searchString}}" placeholder="keywords" aria-label="Search">
            <!--<input type="text" name="organizer" value = """ placeholder="organizer" class="form-control me-1">
            <input type="text" name="city" value = "" placeholder="city" class="form-control me-1">-->
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="/search" class="btn btn-secondary ms-2">Reset</a>
        </form>
          
    </div>
    
        @if($searchString)
        <h2>Found {{count($events)}} Events for {{$searchString}}</h2>
        @else
        <h2>{{count($events)}} upcoming events in {{$city}}</h2>
        @endif

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
                                <span class="text-dark" >{!! $event->shortDescription() !!}...</span>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                       <li><span class="text-dark">When? {{date('m/d/y, h:m', strtotime($event->date))}}</span></li> 
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

        @if($profiles)
        <h2>Found {{count($profiles)}} matching profiles</h2>
        

        @foreach($profiles as $profile)

        <div class="card mb-5">
            <a href="/organizer-profile/{{$profile->id}}">
                <div class="card-body">
    
                    <div class="row">
                        <div class="col-3">
                            
                            <div class="pe-3 m-2">
                                <img src="{{$profile->profileImage()}}" class="w-100 rounded-circle img-thumbnail" style="max-width: 80px">
                            </div>
                           
                        </div>
    
                        <div class="col-9">
                            <div class="card">
                                <div class="card-body">
                                    <span class="text-dark h3" >{{ $profile->name}}</span>
                                    <ul class="list-unstyled">
                                       <li><span class="text-dark">{{$profile->contact}}</span></li> 
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            
        </div>

        @endforeach

        @endif


 </div>
    


@endsection