let chats = []
let online = 0

const socketCore = (io) => {
  io.on('connection', (socket) => {
    online++
    io.emit('online', online)

    // Get Socket Data
    socket.on('get-socket-data', () => {
      socket.emit('online', online)
      socket.emit('chats', chats)
    })

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
      if(!vip.number) return

      io.emit('notify', {
        id: (new Date()).getTime(),
        effect: effect == 'vip' ? `vip-${vip.number}` : effect,
        content: content,
        dup: 2000
      })
    })

    // On Chat
    socket.on('chat', ({account, vip, type, message}) => {
      if(!account || !vip || !message) return
      if(!vip.number) return

      const data = {
        id: (new Date()).getTime(),
        account: account,
        type: type,
        vip: vip.number,
        message: message
      }

      chats.push(data)
      io.emit('chat', data)
      if(chats.length > 20) return chats.shift()
    })

    // Reset Chat
    socket.on('reset-chats', () => {
      chats = []
      io.emit('chats', chats)
    })

    // Disonnect
    socket.on('disconnect', () => {
      online--
      io.emit('online', online)
    })
  })  
}

module.exports = socketCore