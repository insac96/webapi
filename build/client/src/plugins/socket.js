import Vue from 'vue'
import VueSocketIO from 'vue-socket.io'
import SocketIO from 'socket.io-client'

const uriSocket = process.env.NODE_ENV === 'production' ? window.SOCKETURL : 'http://localhost:5000'

Vue.use(new VueSocketIO({
  debug: true,
  connection: SocketIO(uriSocket, {}),
}))