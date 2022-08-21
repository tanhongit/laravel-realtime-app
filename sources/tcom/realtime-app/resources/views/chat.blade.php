@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row chat-row">
            <div class="col-md-3">
                <div class="users">
                    <h5>Users</h5>
                    <ul class="list-group list-chat-item">
                        @if($users->count())
                            @foreach($users as $user)
                                <li class="chat-user-list">
                                    <a href="{{ route('message.index', $user->id) }}">
                                        <div class="chat-image">
                                            {!! makeImageFromName($user->name) !!}
                                            <i class="fa fa-circle user-status-icon user-icon-{{ $user->id }}"
                                               title="away"></i>
                                        </div>

                                        <div class="chat-name font-weight-bold">
                                            {{ $user->name }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
