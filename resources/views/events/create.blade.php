@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/event" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                
                <div class="row">
                    <h1>Add New Event</h1>
                </div>

                <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label">title</label>

                            <input id="title" 
                            name="title"
                            type="text" 
                            class="form-control @error('title') is-invalid @enderror" caption="title" 
                            value="{{ old('title')}}"  
                            required autocomplete="title" autofocus>

                            @error('title')
                                    <strong>{{ $message }}</strong>
                            @enderror
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label">description</label>

                        <textarea id="editor" 
                        name="description"
                        type="text" 
                        class="form-control @error('description') is-invalid @enderror" caption="description" 
                        value="{{ old('description')}}"  
                        required autocomplete="description" autofocus>
                        </textarea>

                        @error('description')
                                <strong>{{ $message }}</strong>
                        @enderror
                </div>

                <div class="row mb-3">
                    <label for="date" class="col-md-4 col-form-label">date</label>

                        <input id="date" 
                        name="date"
                        type="datetime-local" 
                        class="form-control @error('date') is-invalid @enderror" caption="date" 
                        value="{{ old('date')}}">

                        @error('date')
                                <strong>{{ $message }}</strong>
                        @enderror
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-md-4 col-form-label">city</label>

                        <input id="city" 
                        name="city"
                        type="text" 
                        class="form-control @error('city') is-invalid @enderror" caption="city" 
                        value="{{ old('city')}}">

                        @error('city')
                                <strong>{{ $message }}</strong>
                        @enderror
                </div>


                <div class="row">
                    <label for="image" class="col-md-4 col-form-label">Image: Spice up your event, optional</label>
                    <input type="file" class="form-control-file" id="image" name="image" enctype="multipart/form-data">

                    @error('image')
                            <strong>{{ $message }}</strong>
                    @enderror
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Add New Event</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection