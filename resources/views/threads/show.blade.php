@extends('layouts.app')

@section('criticalCss')
    @if(file_exists(public_path('/css/critical/threads.show.min.css')))
        <style>{!! file_get_contents(public_path('/css/critical/threads.show.min.css')) !!}</style>
    @endif
@endsection

@section('head')
    <link rel="stylesheet" href="/css/tribute.css">
@endsection

@section('content')

    <thread inline-template :thread="{{ $thread }}">

        <!-- 2 column wrapper -->
        <div class="flex-grow w-full max-w-7xl mx-auto lg:flex">
            <!-- Left sidebar & main wrapper -->
            <div class="flex-1 min-w-0 xl:flex">

                <div class="border-b border-neon xl:border-b-0 lg:min-w-0 lg:flex-1">
                    <div class="h-full py-6 px-4 sm:px-6 lg:px-8">
                        <!-- Start main area-->
                        <div class="relative h-full" style="min-height: 36rem;">


                            <template v-if="!editing" v-cloak>
                                @component('profiles.activities.activity')
                                    @slot('heading')
                                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 justify-between align-middle">
                                            <div class="flex flex-row items-center">
                                                <div class="mr-3 w-8 h-8">
                                                    <img src="{{ $thread->creator->avatar_path }}"
                                                         alt="Avatar" width="32" height="32" class="rounded-full w-8 h-8"
                                                    >
                                                </div>

                                                <p class="text-white">
                                                    <a class="text-neon hover:text-neon-dark"
                                                        href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                                    posted
                                                    <a class="text-neon hover:text-neon-dark"
                                                       href="{{ $thread->path() }}" v-text="title"></a>
                                                </p>

                                            </div>

                                            <div class="flex flex-row">

                                                <button
                                                    v-if="authorize('owns', thread)"
                                                    @click="showEdit"
                                                    type="button"
                                                    class="button-neon inner-shadow-neon inline-flex items-center px-3 py-2 mr-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                                                    <font-awesome-icon :icon="editIcon"
                                                                       class="h-5 w-5 fa-fw"></font-awesome-icon>
                                                </button>

                                                @can('delete', $thread)
                                                    <form action="{{ $thread->path() }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="button-neonSecondary inner-shadow-neonSecondary inline-flex items-center px-3 py-2 h-full text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neonSecondary-dark focus:ring-neonSecondary-dark">
                                                            <font-awesome-icon
                                                                :icon="deleteIcon"
                                                                class="h-5 w-5 fa-fw"></font-awesome-icon>
                                                        </button>

                                                    </form>
                                                @endcan
                                            </div>
                                        </div>

                                    @endslot
                                    @slot('body')
                                        <div v-html="body"></div>
                                    @endslot
                                @endcomponent
                            </template>

                            <template v-else>
                                @component('profiles.activities.activity')
                                    @slot('heading')
                                        <div class="w-100">
                                            <div class="form-group mb-0">
                                                <input
                                                    v-model="form.title"
                                                    type="text"
                                                    class="block w-full rounded-md sm:text-sm bg-transparent border border-neon placeholder-neon text-white focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark"
                                                    name="title"
                                                    id="title">
                                            </div>
                                        </div>
                                    @endslot
                                    @slot('body')
                                        <form @submit.prevent="update">
                                            <textarea
                                                v-model="form.body"
                                                type="text"
                                                class="bg-transparent border-2 border-neon placeholder-neon text-white block w-full sm:text-sm rounded-md focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark"
                                                required
                                                rows="5"
                                            ></textarea>

                                            <button type="submit" class="button-neon inner-shadow-neon inline-flex items-center px-3 py-2 mt-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                                                Update
                                            </button>
                                            <button type="button" class="ml-2 button-neonSecondary inner-shadow-neonSecondary inline-flex items-center px-3 py-2 mt-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neonSecondary-dark focus:ring-neonSecondary-dark" @click="resetForm">
                                                Cancel
                                            </button>
                                        </form>
                                    @endslot
                                @endcomponent
                            </template>

                            <div class="mt-5">
                                <replies
                                    @added="replyAdded"
                                    @removed="replyRemoved"
                                ></replies>
                            </div>


                        </div>
                        <!-- End main area -->
                    </div>
                </div>

                <div class="xl:flex-shrink-0 xl:w-80">
                    <div class="h-full px-4 py-6 sm:pr-6 lg:pr-8">
                        <!-- Start right column area -->
                        <div class="h-full relative" style="min-height: 12rem;">

                            <div class="frame-neon hover:box-shadow-neon overflow-hidden rounded-lg divide-y divide-neon">
                                <div class="px-4 py-5 sm:px-6 text-white">
                                    <p>This thread was published {{ $thread->created_at->diffForHumans() }}
                                        by <a class="text-neon hover:text-neon-dark"
                                            href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>,
                                        and currently has <span v-text="repliesCount"></span> comments.
                                    </p>
                                </div>
                                <div v-if="signedIn" class="px-4 py-5 sm:p-6">
                                    <div class="flex flex-row relative">
                                        <subscribe-button
                                            v-if="signedIn"
                                            :active="{{ json_encode($thread->isSubscribedTo) }}"
                                        ></subscribe-button>

                                        <button
                                            v-if="authorize('isAdmin')"
                                            @click="toggleLock"
                                            v-text="locked ? 'Unlock' : 'Lock'"
                                            class="button-neonSecondary ground-shadow-neonSecondary inner-shadow-neonSecondary inline-flex items-center px-3 py-2 h-full text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neonSecondary-dark focus:ring-neonSecondary-dark"
                                            :class="locked ? 'text-neonSecondary-dark bg-neonSecondary' : ''"
                                            :style="locked ? 'text-shadow: none;' : ''"
                                        >
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- End right column area -->
                    </div>
                </div>

            </div>

        </div>
    </thread>

@endsection
