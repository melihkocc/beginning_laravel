<script setup>
import Peer from 'simple-peer'
import { ref } from 'vue'

const message = ref('')
const messages = ref([])
const peer = ref(null)

const startPeer = (initiator = false) => {
  peer.value = new Peer({ initiator, trickle: false })

  peer.value.on('signal', data => {
    console.log("SIGNAL DATA TO SHARE:", JSON.stringify(data))
    // bunu karşı tarafa bir şekilde ilet (QR, kopyala yapıştır, sinyalleşme)
  })

  peer.value.on('connect', () => {
    console.log('✅ Bağlantı kuruldu')
  })

  peer.value.on('data', data => {
    messages.value.push({ from: 'other', text: data.toString() })
  })
}

const sendMessage = () => {
  peer.value.send(message.value)
  messages.value.push({ from: 'me', text: message.value })
  message.value = ''
}
</script>

<template>
  <div>
    <h2>Offline Mesajlaşma</h2>
    <button @click="startPeer(true)">🟢 Başlatıcı Ol</button>
    <button @click="startPeer(false)">🟡 Katılımcı Ol</button>
    <input v-model="message" placeholder="Mesaj yaz..." />
    <button @click="sendMessage">Gönder</button>
    <ul>
      <li v-for="msg in messages" :key="msg.text">{{ msg.from }}: {{ msg.text }}</li>
    </ul>
  </div>
</template>
