@extends('layouts.app')

@section('content')

<div class="container">
    <form action="/organizer-profile/{{ $organizerProfile->id }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-8 offset-2">
                
                <div class="row">
                    <h1>Edit Profile</h1>
                </div>
                <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label">Name</label>

                            <input id="name" 
                            name="name"
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" name="name" 
                            value="{{ old('name') ?? $organizerProfile->name }}"  
                            autocomplete="name" autofocus>

                            @error('name')
                                    <strong>{{ $message }}</strong>
                            @enderror

                </div>

                <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label">Description</label>

                            <input id="description" 
                            name="description"
                            type="text" 
                            class="form-control @error('description') is-invalid @enderror" caption="description" 
                            value="{{ old('description') ?? $organizerProfile->description }}"  
                            autocomplete="description" autofocus>

                            @error('description')
                                    <strong>{{ $message }}</strong>
                            @enderror

                </div>

                <div class="row mb-3">
                        <label for="contact" class="col-md-4 col-form-label">contact</label>

                            <input id="contact" 
                            name="contact"
                            type="text" 
                            class="form-control @error('contact') is-invalid @enderror" caption="contact" 
                            value="{{ old('contact') ?? $organizerProfile->contact }}"  
                            autocomplete="contact" autofocus>

                            @error('contact')
                                    <strong>{{ $message }}</strong>
                            @enderror

                </div>


                <div class="row">

                    <label for="image" class="col-md-4 col-form-label">Profile Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">

                    @error('image')
                            <strong>{{ $message }}</strong>
                    @enderror
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Save Profile</button>
                </div>

            </div>
        </div>
    </form>
</div>



@endsection
