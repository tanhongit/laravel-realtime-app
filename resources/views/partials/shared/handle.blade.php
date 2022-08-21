@push('scripts')
    <script>
        $(function () {
            let chatInput = $(".chat-input");

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

            chatInput.keypress(function (e) {
                let message = $(this).html();
                if (e.which === 13 && !e.shiftKey && !e.ctrlKey) {
                    // alert('Test enter');
                    let url = "{{ route('message.create') }}";
                    let form = $(this);
                    let formData = new FormData();
                    let token = "{{ csrf_token() }}";

                    formData.append('message', message);
                    formData.append('_token', token);
                    formData.append('receiver_id', friendId);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        success: function (response) {
                            if (response.success) {
                                console.log(response.data);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
