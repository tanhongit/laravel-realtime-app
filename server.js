const express = require('express');
const fs = require('fs');
const app = express();
require('dotenv').config();

const https = require('https');
let options = {
    key: fs.readFileSync('certs/realtime-app.local-key.pem').toString(),
    cert: fs.readFileSync('certs/realtime-app.local.pem').toString(),
    requestCert: false,
    rejectUnauthorized: false
};
const port = 3001; // use optional port
const server = https.createServer(options, app);
server.listen(port, () => {
    console.log(`Server running on port ${port}`);
    console.log('listening on https://realtime-app.local:' + port);
    console.log('Check on https://realtime-app.local:' + port + '/hello');
});

app.get('/hello', (req, res) => {
    res.send('<h1>Hello world</h1>');
});

const {Server} = require('socket.io');
const io = new Server(server);
let users = [];

let redisPort = process.env.REDIS_PORT;
let redisHost = process.env.REDIS_HOST;
let ioRedis = require('ioredis');
let redis = new ioRedis(redisPort, redisHost);

io.on('connection', function (socket) {
    socket.on("user_connected", function (authId) {
        users[authId] = socket.id;
        io.emit('updateUserStatus', users);
        console.log("Auth user connected: " + authId);
    });

    socket.on('disconnect', function () {
        let i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);
        console.log('disconnect: ', users);
    });
});

redis.subscribe('private-channel', (err, count) => {
    console.log('subscribed to private_channel');
});

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
});

