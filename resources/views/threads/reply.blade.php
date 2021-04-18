<reply :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{ $reply->id }}">
        @component('profiles.activities.activity')
            @slot('heading')
                <div>
                    <a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
                    said
                    {{ $reply->created_at->diffForHumans() }}
                </div>
                <div class="inline">
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                    @can('update', $reply)
                        <div class="d-flex align-items-center justify-content-center" @click="showEdit">
                            <button class="btn btn-primary">
                                <i class="far fa-edit"></i>
                            </button>
                        </div>
                    @endcan
                    @can('delete', $reply)
                        <div class="d-flex align-items-center justify-content-center" @click="destroy">
                            <button class="btn btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    @endcan
                </div>

            @endslot

            @slot('body')
                <div v-if="editing">
                    <div class="form-group">
                        <textarea v-model="body"
                                  type="text" class="form-control"
                                  required
                                  rows="5"></textarea>
                    </div>
                    <button class="btn btn-primary btn-xs" @click="update">
                        Update
                    </button>
                    <button class="btn btn-link btn-xs" @click="hideEdit">
                        Cancel
                    </button>
                </div>
                <div v-else>
                    @{{ body }}
                </div>
            @endslot
        @endcomponent
    </div>
</reply>
