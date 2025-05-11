<script setup>
import Title from "@/Components/Title.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import dayjs from "dayjs";

const breadcrumbs = ref([
    {
        title: "Yardım Talepleri",
        route: route("help-disease.index"),
    },
    {
        title: "Mesajlaş",
    },
]);

const { props } = usePage();

const allMessages = ref([]);

onMounted(() => {
    let doctorMessages = [];
    let patientMessages = [];

    try {
        doctorMessages = JSON.parse(props.help.doctor_messages || "[]").map(
            (m) => ({
                ...m,
                sender: "doctor",
            })
        );
    } catch (e) {
        console.error("Doctor message parse error", e);
    }

    try {
        patientMessages = JSON.parse(props.help.patient_messages || "[]").map(
            (m) => ({
                ...m,
                sender: "patient",
            })
        );
    } catch (e) {
        console.error("Patient message parse error", e);
    }

    allMessages.value = [...doctorMessages, ...patientMessages].sort(
        (a, b) => new Date(a.created_at) - new Date(b.created_at)
    );
});

const form = useForm({
    message: "",
    created_at: "",
});

// Mesaj gönderme
const sendMessage = async () => {
    if (form.message.trim() === "") return;

    const now = new Date().toISOString();

    form.post(route("help-message.send", props.help.id), {
        data: { message: form.message },
        onSuccess: () => {
            if (props.auth.user.plan == "doctor") {
                allMessages.value.push({
                    message: form.message,
                    created_at: now,
                    sender: "doctor",
                });
            } else {
                allMessages.value.push({
                    message: form.message,
                    created_at: now,
                    sender: "patient",
                });
            }

            // Listeyi tekrar tarihe göre sırala
            allMessages.value.sort(
                (a, b) => new Date(a.created_at) - new Date(b.created_at)
            );

            form.message = "";
        },
        onError: () => {
            console.error("Mesaj gönderilemedi");
        },
    });
};
</script>

<template>
    <Head title="Mesaj" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-6 space-y-8">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                <div>
                    <Title text="Mesajlaş" />
                    <div class="mt-2 text-sm text-gray-600">
                        Oluşturulma Tarihi :
                        {{ dayjs(props.help.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
            </div>

            <div class="message-container bg-white p-6 rounded-lg shadow-lg">
                <div
                    class="messages-box h-96 overflow-y-scroll p-4 border-b border-gray-300"
                >
                    <div
                        v-for="(message, index) in allMessages"
                        :key="index"
                        :class="[
                            'message p-3 my-2 rounded-lg',
                            message.sender === 'doctor'
                                ? 'bg-blue-100'
                                : 'bg-green-100',
                        ]"
                    >
                        <div class="text-sm font-semibold">
                            {{
                                message.sender === "doctor"
                                    ? `${props.help.doctor.name} ${props.help.doctor.surname}`
                                    : `${props.help.patient.name} ${props.help.patient.surname}`
                            }}
                        </div>
                        <div class="text-sm">{{ message.message }}</div>
                        <div class="text-xs text-gray-500">
                            {{
                                dayjs(message.created_at).format(
                                    "DD/MM/YYYY HH:mm"
                                )
                            }}
                        </div>
                    </div>
                </div>

                <div class="send-message mt-4">
                    <textarea
                        v-model="form.message"
                        rows="3"
                        class="w-full p-3 border rounded-lg"
                        placeholder="Mesajınızı buraya yazın..."
                    ></textarea>
                    <button
                        @click="sendMessage"
                        class="w-full bg-blue-600 text-white mt-2 p-2 rounded-lg"
                    >
                        Mesaj Gönder
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.message-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.messages-box {
    max-height: 400px;
    overflow-y: scroll;
}

.message {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
}

.message.bg-blue-100 {
    background-color: #ebf8ff;
}

.message.bg-green-100 {
    background-color: #f0fff4;
}

.send-message {
    margin-top: 20px;
}
</style>
