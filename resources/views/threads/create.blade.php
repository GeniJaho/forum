@extends('layouts.app')

@section('head')
    <script>
        function callbackThen(response) {
            response.json().then(function (data) {
                if (data.success) {
                    document.getElementById('form').classList.remove('d-none');
                }
            });
        }

        function callbackCatch(error) {
            alert('You\'re a robot, Harry! Please reload the page!');
        }
    </script>

    {!! htmlScriptTagJsApi([
            'action' => 'thread',
            'callback_then' => 'callbackThen',
            'callback_catch' => 'callbackCatch'
     ]) !!}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        <form
                            id="form"
                            action="/threads"
                            method="post"
                            class="d-none"
                        >
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
