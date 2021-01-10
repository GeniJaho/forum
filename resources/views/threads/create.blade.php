@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        <form action="/threads" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Choose a Channel:</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">Choose one:</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}"
                                            {{ old('channel_id') == $channel->id ? 'selected' : ''}}
                                        >{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" required
                                       id="title" value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea type="text" class="form-control" id="body" required
                                          name="body" rows="8">{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if($errors->isNotEmpty())
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
