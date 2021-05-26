@extends('layouts.app')

@section('head')
    <script>
        function callbackThen(response) {
            response.json().then(function (data) {
                if (data.success) {
                    document.getElementById('form').classList.remove('hidden');
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
    <!-- 2 column wrapper -->
    <div class="flex-grow w-full max-w-xl mx-auto lg:flex">
        <!-- Left sidebar & main wrapper -->
        <div class="flex-1 min-w-0 xl:flex">

            <div class="border-b border-neon xl:border-b-0 lg:min-w-0 lg:flex-1">
                <div class="h-full py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Start main area-->
                    <div class="relative h-full" style="min-height: 36rem;">
                        <form class="hidden frame-neon overflow-hidden rounded-lg"
                              id="form"
                              action="/threads"
                              method="post"
                        >
                            @csrf

                            <div class="px-4 py-5 sm:px-6 space-y-6">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-white">
                                        Create a New Thread
                                    </h3>
                                </div>

                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-12">
                                        <label for="channel_id" class="block text-sm font-medium text-neon">
                                            Channel
                                        </label>
                                        <select id="channel_id" name="channel_id" autocomplete="channel_id"
                                                class="mt-1 block bg-neon-extraDark text-white w-full py-2 px-3 frame-neon border rounded-md sm:text-sm focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark"
                                        >
                                            <option value="">Choose one:</option>
                                            @foreach($channels ?? [] as $channel)
                                                <option value="{{ $channel->id }}"
                                                    {{ old('channel_id') == $channel->id ? 'selected' : ''}}
                                                >{{ $channel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="sm:col-span-12">
                                        <label for="title" class="block text-sm font-medium text-neon">
                                            Title
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="title" id="title" autocomplete="title" required
                                                   value="{{ old('title') }}"
                                                   class="block w-full rounded-md sm:text-sm bg-transparent border border-neon placeholder-neon text-white focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-12">
                                        <label for="body" class="block text-sm font-medium text-neon">
                                            Body
                                        </label>
                                        <div class="mt-1">
                                            <textarea id="body" name="body" rows="8" required
                                                      class="block w-full sm:text-sm rounded-md bg-transparent border border-neon placeholder-neon text-white focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark">{{ old('body') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                @if($errors->isNotEmpty())
                                       <div class="space-y-1">
                                           @foreach($errors->all() as $error)
                                               <p class="text-pink text-sm" role="alert">{{ $error }}</p>
                                           @endforeach
                                       </div>
                                @endif

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="button-neon inner-shadow-neon inline-flex justify-center py-2 px-4 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End main area -->
                </div>
            </div>

        </div>

    </div>
@endsection
