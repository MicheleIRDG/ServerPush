var express = require('express');
var http = require('http');

var app = express();

// const cors = require('cors');
// app.use(cors({
//     origin: 'http://localhost:3000'
// }));
var server = http.createServer(app);

var io = require('socket.io')(server, {
  cors: {
    origin: '*',
  }
});

var io_rapporto_audit = io.of("/rapporto_audit");

// var path = require('path');

// app.use(express.static(path.join(__dirname,)));


app.get('/', (req, res) => {
  // res.sendFile(__dirname + '/index.html');
  res.send("hello to server socket suite!")
});


io_rapporto_audit.on('connection', (socket) => {
  console.log('new user connected');

  socket.on('cambio risposta default', (id_domanda,risposta,selezionato, data_caricamento) => {
    socket.broadcast.emit('cambio risposta default', id_domanda, risposta, selezionato, data_caricamento);
  });

  socket.on('aggiungi rilievo', (id, text, id_domanda, id_row) => {
    socket.broadcast.emit('aggiungi rilievo', id, text, id_domanda, id_row);
  });

  socket.on('rimuovi rilievo', (id, id_domanda) => {
    socket.broadcast.emit('rimuovi rilievo', id, id_domanda);
  });

  socket.on('typing evidenza', (id_domanda) => {
    socket.broadcast.emit('typing evidenza', id_domanda);
  });

  socket.on('cambio evidenza', (id_domanda, text, data_caricamento) => {
    socket.broadcast.emit('cambio evidenza', id_domanda, text, data_caricamento);
  });

  socket.on('cambio risposta progress',(id_domanda, value, data_caricamento, gruppo, totale) => {
    socket.broadcast.emit('cambio risposta progress', id_domanda, value, data_caricamento, gruppo, totale);
  });

});

server.listen(3000, () => {
  console.log('Server Socket Suite listening on :3000');
});