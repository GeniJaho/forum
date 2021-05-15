@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/tribute.css">
@endsection

@section('content')

    <thread inline-template :thread="{{ $thread }}">

        <!-- 2 column wrapper -->
        <div class="flex-grow w-full max-w-7xl mx-auto lg:flex">
            <!-- Left sidebar & main wrapper -->
            <div class="flex-1 min-w-0 bg-white xl:flex">

                <div class="bg-white border-b border-gray-200 xl:border-b-0 lg:min-w-0 lg:flex-1">
                    <div class="h-full py-6 px-4 sm:px-6 lg:px-8">
                        <!-- Start main area-->
                        <div class="relative h-full" style="min-height: 36rem;">


                            <template v-if="!editing" v-cloak>
                                @component('profiles.activities.activity')
                                    @slot('heading')
                                        <div class="flex flex-row justify-between">
                                            <div class="flex flex-row">
                                                <img src="{{ $thread->creator->avatar_path }}"
                                                     alt="Avatar" width="25" height="25" class="mr-2"
                                                >

                                                <p>
                                                    <a class="text-indigo-600 hover:text-indigo-500"
                                                        href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                                    posted
                                                    <a class="text-indigo-600 hover:text-indigo-500"
                                                       href="{{ $thread->path() }}" v-text="title"></a>
                                                </p>

                                            </div>

                                            <div class="flex flex-row">

                                                <button
                                                    v-if="authorize('owns', thread)"
                                                    @click="showEdit"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 mr-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <font-awesome-icon :icon="editIcon"
                                                                       class="h-5 w-5 fa-fw"></font-awesome-icon>
                                                </button>

                                                @can('delete', $thread)
                                                    <form action="{{ $thread->path() }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="inline-flex items-center px-3 py-2 h-full border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
                                                    class="form-control mb-0"
                                                    name="title"
                                                    id="title">
                                            </div>
                                        </div>

                                        <div class="inline">
                                            <div v-if="authorize('owns', thread) && !editing"
                                                 class="d-flex align-items-center justify-content-center"
                                                 @click="showEdit"
                                            >
                                                <button class="btn btn-primary">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </div>
                                        </div>

                                    @endslot
                                    @slot('body')
                                        <form @submit.prevent="update">
                                            <div class="form-group">
                                            <textarea
                                                v-model="form.body"
                                                type="text"
                                                class="form-control"
                                                required
                                                rows="5"
                                            ></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-xs">
                                                Update
                                            </button>
                                            <button type="button" class="btn btn-link btn-xs" @click="resetForm">
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

                <div class="xl:flex-shrink-0 xl:w-80 bg-white">
                    <div class="h-full px-4 py-6 sm:pr-6 lg:pr-8 xl:pr-0">
                        <!-- Start right column area -->
                        <div class="h-full relative" style="min-height: 12rem;">

                            <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                                <div class="px-4 py-5 sm:px-6">
                                    <p>This thread was published {{ $thread->created_at->diffForHumans() }}
                                        by <a class="text-indigo-600 hover:text-indigo-500"
                                            href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>,
                                        and currently has <span v-text="repliesCount"></span> comments.
                                    </p>
                                </div>
                                <div v-if="signedIn" class="bg-gray-50 px-4 py-5 sm:p-6">
                                    <div class="flex flex-row">
                                        <subscribe-button
                                            v-if="signedIn"
                                            :active="{{ json_encode($thread->isSubscribedTo) }}"
                                        ></subscribe-button>

                                        <button
                                            v-if="authorize('isAdmin')"
                                            @click="toggleLock"
                                            v-text="locked ? 'Unlock' : 'Lock'"
                                            class="inline-flex items-center px-3 py-2 h-full border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <font-awesome-icon
                                                :icon="deleteIcon"
                                                class="h-5 w-5 fa-fw"></font-awesome-icon>
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
