@extends('layouts.app')

<style>
    .select2-container {
        width: 100% !important;
    }
</style>
@section('content')
    <div class="row chat-row">
        <div class="col-md-3">
            @include('partials.chat.leftBar')
        </div>
        <div class="col-md-9 chat-section">
            <div class="chat-header">
                <div class="chat-image">
                    {!! makeImageFromName($friendInfo->name) !!}
                    <i class="fa fa-circle user-status-icon user-icon-{{ $friendInfo->id }}" title="away"
                       id="userStatusHead{{ $friendInfo->id }}"></i>
                </div>

                <div class="chat-name font-weight-bold">
                    {{ $friendInfo->name }}
                </div>
            </div>

            <div class="chat-body" id="chatBody">
                <div class="message-listing" id="messageWrapper">
                </div>
            </div>

            <div class="chat-box">
                <div class="chat-input bg-white" id="chatInput" contenteditable="">
                </div>

                <div class="chat-input-toolbar">
                    <button title="Add File" class="btn btn-light btn-sm btn-file-upload">
                        <i class="fa fa-paperclip"></i>
                    </button>
                    |
                    <button title="Bold" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('bold', false, '');">
                        <i class="fa fa-bold tool-icon"></i>
                    </button>

                    <button title="Italic" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('italic', false, '');">
                        <i class="fa fa-italic tool-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            let authId = "{{ auth()->user()->id }}";
            let ipAddress = '//realtime-app.local';
            let socketPort = '3001'; // same by port on server.js

            let socket = io(ipAddress + ':' + socketPort, {secure: true, transports: ['websocket']});
            let friendId = "{{ $friendInfo->id }}";

            socket.on('connect', function () {
                //alert('Test connect');
                socket.emit('user_connected', authId);
            });

            socket.on('updateAuthStatus', (data) => {
                $.each(data, function (key, val) {
                    if (val !== null && val !== 0) {
                        let $userIcon = $(".user-icon-" + key);
                        $userIcon.addClass('text-success');
                        $userIcon.attr('title', 'Online');
                    }
                });
            });
        });
    </script>
@endpush
