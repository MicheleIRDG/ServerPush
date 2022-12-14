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
  console.log('Rapporto_audit => new user connected');

  socket.on('join rapporto audit', (id) =>{
    console.log('Rapporto_audit => mi collego alla room: ' + id);
    socket.leave(socket.room);
    socket.join(id);
    socket.room = id;
  })

  socket.on('cambio risposta default', (id_domanda,risposta,selezionato, data_caricamento) => {
    socket.broadcast.to(socket.room).emit('cambio risposta default', id_domanda, risposta, selezionato, data_caricamento);
  });

  socket.on('aggiungi rilievo', (id, text, id_domanda, id_row) => {
    socket.broadcast.to(socket.room).emit('aggiungi rilievo', id, text, id_domanda, id_row);
  });

  socket.on('rimuovi rilievo', (id, id_domanda) => {
    socket.broadcast.to(socket.room).emit('rimuovi rilievo', id, id_domanda);
  });

  socket.on('typing evidenza', (id_domanda) => {
    socket.broadcast.to(socket.room).emit('typing evidenza', id_domanda);
  });

  socket.on('cambio evidenza', (id_domanda, text, data_caricamento) => {
    socket.broadcast.to(socket.room).emit('cambio evidenza', id_domanda, text, data_caricamento);
  });

  socket.on('cambio risposta progress',(id_domanda, value, data_caricamento, gruppo, totale) => {
    socket.broadcast.to(socket.room).emit('cambio risposta progress', id_domanda, value, data_caricamento, gruppo, totale);
  });

});

const port = process.env.PORT || 3000;
server.listen(port, () => {
  console.log('Server Socket Suite listening on :3000');
});
