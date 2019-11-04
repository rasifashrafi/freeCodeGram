@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex">
        <div class="col-3">
            <a href=""><img src="{{ $user->profile->profileImage() }}" alt="" class="rounded-circle w-100"></a>
        </div>
        <div class="col-9">
            <div class="p-3">
                <h1 class="pr-3" style="text-transform: uppercase;">{{ $user -> username }}</h1>
                <follow-button user-id="{{ $user->id }}"></follow-button>

                @can('update', $user->profile)
                    <button>
                        <a href="/p/create">Add New Post</a>
                    </button>
                @endcan

                @can('update', $user->profile)
                <button class="pr-3"><a href="/profile/{{ $user->id }}/edit">Edit Profile</a></button>
                @endcan
                
            </div>

            <div class="d-flex">
                <div class="col-3 font-weight-bold">{{ $postCount }} posts</div>
                <div class="col-3 font-weight-bold">{{ $followersCount }} folowers</div>
                <div class="col-3 font-weight-bold">{{ $followingCount }} following</div>
            </div>

            <div class="pt-3">
                <h4>
                {{ $user->profile->title }}
                </h4>
                <p>
                {{ $user->profile->description }}
                </p>
                <h4>
                {{ $user->profile->url }}
                </h4>
            </div>
        </div>
    </div>

    <div class="border-top border-bottom d-flex">
        <h5 class="col-6 text-center">
            Posts
        </h5>
        <h5 class="col-6 text-center">
            Tagged
        </h5>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
        <div class="col-4 pb-4">
            <a href="/p/{{ $post->id }}">
                <img src="/storage/{{ $post->image }}" alt="" class="w-100">
            </a>
        </div>
        @endforeach
    </div>

</div>
@endsection
