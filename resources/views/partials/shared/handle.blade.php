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

            socket.on('updateUserStatus', (data) => {
                // for disconnect user
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                $userStatusIcon.attr('title', 'Away');

                // for connected user
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
