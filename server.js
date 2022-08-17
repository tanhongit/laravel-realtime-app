const app = require('express')();
const http = require('http').Server(app);
const io = require('socket.io')(http);

http.listen(3105, () => {
    console.log('listening on *:3105');
});
