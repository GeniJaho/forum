@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/tribute.css">
@endsection

@section('content')

    <thread inline-template :thread="{{ $thread }}">

        <div class="container">
            <div class="row">

                <div class="col-md-8 justify-content-center">
                    <template v-if="!editing" v-cloak>
                        @component('profiles.activities.activity')
                            @slot('heading')
                                <div>
                                    <img src="{{ $thread->creator->avatar_path }}"
                                         alt="Avatar" width="25" height="25" class="mr-2"
                                    >
                                    <span>
                                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                posted
                                <a href="{{ $thread->path() }}" v-text="title"></a>
                                </span>
                                </div>

                                <div class="inline">
                                    <div v-if="authorize('owns', thread)"
                                         class="d-flex align-items-center justify-content-center" @click="showEdit"
                                    >
                                        <button class="btn btn-primary">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </div>

                                    @can('delete', $thread)
                                        <div class="d-flex align-items-center justify-content-center">
                                            <form action="{{ $thread->path() }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            @endslot
                            @slot('body')
                                <span v-html="body"></span>
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
                                         class="d-flex align-items-center justify-content-center" @click="showEdit"
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

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">This thread was published {{ $thread->created_at->diffForHumans() }}
                                by <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>,
                                and currently has
                                @{{ repliesCount }}
                                {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                            </p>

                            <div v-if="signedIn" class="level mt-2">
                                <subscribe-button
                                    v-if="signedIn"
                                    :active="{{ json_encode($thread->isSubscribedTo) }}"
                                ></subscribe-button>

                                <button
                                    v-if="authorize('isAdmin')"
                                    @click="toggleLock"
                                    v-text="locked ? 'Unlock' : 'Lock'"
                                    class="btn btn-warning ml-2"
                                ></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </thread>
@endsection
