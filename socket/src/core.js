const socketCore = (io) => {
  io.on('connection', (socket) => {
    // Notify Admin
    socket.on('notify-admin', content => {
      socket.broadcast.emit('notify', {
        id: (new Date()).getTime(),
        effect: 'admin',
        content: content,
        dup: 10000
      })
    })

    // Notify User
    socket.on('notify-user', ({account, vip, effect, content}) => {
      if(!account || !vip || !effect || !content) return

      io.emit('notify', {
        id: (new Date()).getTime(),
        effect: effect == 'vip' ? `vip-${vip.number}` : effect,
        content: content,
        dup: 2000
      })
    })
  })  
}

module.exports = socketCore