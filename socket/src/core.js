const socketCore = (io) => {
  io.on('connection', (socket) => {
    socket.on('notify', data => {
      socket.broadcast.emit('notify', data)
    })
  })  
}

module.exports = socketCore