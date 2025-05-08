<script setup>
import { ref, onMounted, watch } from 'vue';
import localforage from 'localforage';
import { database } from '@/firebase';
import { ref as dbRef, push, onChildAdded } from 'firebase/database';

const props = defineProps({
  auth: Object
});

const user = props.auth;
const message = ref('');
const messages = ref([]);

localforage.config({ name: 'AfetYardimApp', storeName: 'chatMessages' });

onMounted(async () => {
  const saved = await localforage.getItem('messages');
  console.log(saved)
  if (saved) messages.value = saved;

  const messagesRef = dbRef(database, "messages");
  onChildAdded(messagesRef, (snapshot) => {
    const msg = snapshot.val();
    if (!messages.value.find((m) => m.created_at === msg.created_at)) {
      messages.value.push(msg);
    }
  });

  window.addEventListener('online', resendPendingMessages);
});

watch(messages, () => {
  localforage.setItem('messages', JSON.parse(JSON.stringify(messages.value)));
}, { deep: true });


const sendMessage = () => {
  if (!message.value.trim() || !user) return;

  const newMsg = {
    text: message.value,
    created_at: Date.now(),
    user: {
      id: user.id,
      name: user.name,
    },
    pending: !navigator.onLine
  };

  messages.value.push(newMsg);
  message.value = "";

  if (navigator.onLine) {
    push(dbRef(database, "messages"), { ...newMsg, pending: false });
  }
};

const resendPendingMessages = () => {
  const pendingMessages = messages.value.filter(msg => msg.pending);
  pendingMessages.forEach((msg) => {
    push(dbRef(database, "messages"), { ...msg, pending: false });
    msg.pending = false;
  });
};
</script>

<template>
  <div>
    <h2 class="text-xl font-bold mb-2">👤 {{ user.name }} ile Sohbet</h2>
    <div
      v-for="msg in messages"
      :key="msg.created_at"
      class="mb-2"
    >
      <strong>{{ msg.user?.name || 'Bilinmeyen' }}:</strong>
      <span :class="{ 'opacity-50 italic': msg.pending }">
        {{ msg.text }}
      </span>
    </div>

    <input
      v-model="message"
      @keyup.enter="sendMessage"
      placeholder="Mesaj yaz..."
      class="border p-2 w-full mt-4"
    />
    <button
      @click="sendMessage"
      class="bg-blue-500 text-white px-4 py-2 mt-2 rounded"
    >
      Gönder
    </button>
  </div>
</template>
