@extends('layouts.app')

@section('content')

<div class="container">

    @foreach($events as $event)
    <div class="row mb-5">
        <div class="col-8">
            <a href="/event/{{ $event->id }}">
                <img src="{{ $event->image() }}" class="w-50 img-thumbnail" style="width: 100px height: 100px">
            </a>
        </div>
        <div class="col-4">
            <div>
                <a href="/event/{{ $event->id }}">
                    <h1>{{ $event->title}}</h1>
                </a>
                <hr>

                <div>
                    <span class="fw-bold"> Date and Time </span>
                    <p>{{ date('m/d/y, h:m', strtotime($event->date)) }}</p>
                </div>
                <div>
                    <span class="fw-bold"> Address </span>
                    <p>{{ $event->address }}</p>
                </div>
                <div>
                    <span class="fw-bold"> Organizer </span>
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

            </div>
        </div>
    </div>
    @endforeach
</div>


@endsection