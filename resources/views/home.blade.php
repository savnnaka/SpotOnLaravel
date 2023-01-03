@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row pt-2 mb-2">
        <h2>Upcoming events in Tübingen</h2>

        @foreach($events as $event)

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


 </div>
    


@endsection
