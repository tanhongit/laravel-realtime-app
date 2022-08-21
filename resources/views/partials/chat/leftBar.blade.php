<div class="users">
    <h5>Chats</h5>

    <ul class="list-group list-chat-item">
        @if($users->count())
            @foreach($users as $user)
                <a href="{{ route('message.index', $user->id) }}">
                    <li class="chat-user-list
                                @if($user->id == $friendInfo->id) active @endif">
                        <div class="chat-image">
                            {!! makeImageFromName($user->name) !!}
                            <i class="fa fa-circle user-status-icon user-icon-{{ $user->id }}" title="away"></i>
                        </div>
                        <div class="chat-name font-weight-bold">
                            {{ $user->name }}
                        </div>
                    </li>
                </a>
            @endforeach
        @endif
    </ul>
</div>
