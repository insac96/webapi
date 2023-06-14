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

    // Notify Login
    socket.on('notify-login', ({account, vip, effect}) => {
      if(!account || !vip || !effect) return
      if(!vip.number) return
      if(vip.number == 0 && effect == 'vip') return

      socket.broadcast.emit('notify', {
        id: (new Date()).getTime(),
        effect: effect == 'vip' ? `vip-${vip.number}` : effect,
        content: `VIP ${vip.number} - ${account.toUpperCase()} truy cập`,
        dup: 2000
      })
    })
  })  
}

module.exports = socketCore