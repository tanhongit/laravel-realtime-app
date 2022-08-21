@push('scripts')
    <script>
        $(function () {
            let chatInput = $(".chat-input");
            let messageWrapper = $("#messageWrapper");
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

            socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message)
            {
                appendMessageToReceiver(message);
            });


            chatInput.keypress(function (e) {
                let message = $(this).html();
                if ($(this).text() !== '') {
                    if (e.which === 13 && !e.shiftKey && !e.ctrlKey) {
                        // alert('Test enter');
                        chatInput.html('');
                        sendMessage(message);
                        appendMessageToSender(message);
                        return false;
                    }
                }
            });

            function sendMessage(message) {
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

            function appendMessageToSender(message) {
                let name = '{{ $myInfo->name }}';
                let image = '{!! makeImageFromName($myInfo->name) !!}';

                let userInfo = '<div class="col-md-12 user-info">\n' +
                    '<div class="chat-image">\n' + image +
                    '</div>\n' +
                    '\n' +
                    '<div class="chat-name font-weight-bold">\n' +
                    name +
                    '<span class="small time text-gray-500" title="' + getCurrentDateTime() + '">\n' +
                    getCurrentTime() + '</span>\n' +
                    '</div>\n' +
                    '</div>\n';

                let messageContent = '<div class="col-md-12 message-content">\n' +
                    '<div class="message-text">\n' + message +
                    '</div>\n' +
                    '</div>';


                let newMessage = '<div class="row message align-items-center mb-2">'
                    + userInfo + messageContent +
                    '</div>';

                messageWrapper.append(newMessage);
            }

            function appendMessageToReceiver(message) {
                let name = '{{ $friendInfo->name }}';
                let image = '{!! makeImageFromName($friendInfo->name) !!}';

                let userInfo = '<div class="col-md-12 user-info">\n' +
                    '<div class="chat-image">\n' + image +
                    '</div>\n' +
                    '\n' +
                    '<div class="chat-name font-weight-bold">\n' +
                    name +
                    '<span class="small time text-gray-500" title="'+dateFormat(message.created_at)+'">\n' +
                    timeFormat(message.created_at)+'</span>\n' +
                    '</div>\n' +
                    '</div>\n';

                let messageContent = '<div class="col-md-12 message-content">\n' +
                    '<div class="message-text">\n' + message.content +
                    '</div>\n' +
                    '</div>';


                let newMessage = '<div class="row message align-items-center mb-2">'
                    +userInfo + messageContent +
                    '</div>';

                messageWrapper.append(newMessage);
            }
        });
    </script>
@endpush
