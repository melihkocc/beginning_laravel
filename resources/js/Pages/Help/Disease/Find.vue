<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import {
    Card,
    CardHeader,
    CardFooter,
    CardContent,
} from "@/components/ui/card";
import Button from "@/components/ui/button/Button.vue";
import Title from "@/Components/Title.vue";
import Separator from "@/components/ui/separator/Separator.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
} from "@/components/ui/form";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import { Send } from "lucide-vue-next";
import InputError from "@/Components/InputError.vue";
const { props } = usePage();
const breadcrumbs = ref([{ title: "Doktorlar" }]);
const doctors = ref([]);

onMounted(() => {
    doctors.value = props.doctors;
});

const doctorModal = ref(false);
const selectedDoctor = ref(null);

const getRequest = (doctor) => {
    console.log("lalala");
    console.log(doctor);
    selectedDoctor.value = doctor;
    doctorModal.value = true;
};

const form = useForm({
    patient_id: props.auth.user.id,
    doctor_id: null,
    complaint_description: "",
});

const submit = () => {
    form.doctor_id = selectedDoctor.value.id;
    form.post(route('help.store'));
};
</script>

<template>
    <Head title="Uzman Yardım Al" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="doctor-list">
            <Title text="Aktif Doktorlar" class="text-center mb-8" />

            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 p-6"
            >
                <div
                    v-for="doctor in doctors"
                    :key="doctor.id"
                    class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-transform transform hover:-translate-y-2"
                >
                    <Card>
                        <CardHeader>
                            <h3
                                class="text-2xl font-semibold text-center text-gray-800 mb-2"
                            >
                                {{ doctor.name }} {{ doctor.surname }}
                            </h3>
                            <p class="text-center text-gray-500 text-sm">
                                {{ doctor.specialization }}
                            </p>
                        </CardHeader>

                        <CardContent>
                            <div class="space-y-2">
                                <p class="text-gray-700">
                                    <strong>E-posta:</strong> {{ doctor.email }}
                                </p>
                                <p class="text-gray-700">
                                    <strong>İl:</strong> {{ doctor.city }}
                                </p>
                                <p class="text-gray-700">
                                    <strong>İlçe:</strong> {{ doctor.district }}
                                </p>
                                <p class="text-gray-700">
                                    <strong>Adres:</strong> {{ doctor.address }}
                                </p>
                                <p
                                    v-if="doctor.consultation_price"
                                    class="text-gray-700"
                                >
                                    <strong>Danışmanlık Ücreti:</strong>
                                    {{ doctor.consultation_price }} TL
                                </p>
                                <p
                                    v-if="doctor.years_of_experience"
                                    class="text-gray-700"
                                >
                                    <strong>Deneyim:</strong>
                                    {{ doctor.years_of_experience }} yıl
                                </p>
                            </div>
                        </CardContent>

                        <Separator class="my-4" />

                        <CardFooter class="p-6 text-center">
                            <Button
                                @click="getRequest(doctor)"
                                processbutton
                                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors"
                            >
                                Talep Al
                            </Button>
                        </CardFooter>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Dialog :open="doctorModal" @update:open="doctorModal = $event">
        <DialogContent class="max-h-[525px] overflow-y-auto">
            <DialogHeader>
                <DialogTitle>Talep Al</DialogTitle>
                <DialogDescription>
                    {{ selectedDoctor.name }} {{ selectedDoctor.surname }} adlı
                    doktordan talep alıyorsunuz.
                </DialogDescription>
            </DialogHeader>
            <div>
                <Form>
                    <FormField name="hpv">
                        <FormItem>
                            <FormLabel
                                >Şikayet Açıklamanız
                                <span class="text-red-500">*</span></FormLabel
                            >
                            <FormControl>
                                <Textarea 
                                    v-model="form.complaint_description"
                                    maxlength="500"
                                    rows="9"
                                />
                            </FormControl>
                            <InputError
                                class="input-error mt-2"
                                :message="form.errors.complaint_description"
                            />
                        </FormItem>
                    </FormField>
                </Form>
                <Button @click="submit" class="mt-5 w-full" processbutton> <Send /> Gönder</Button>
            </div>
        </DialogContent>
    </Dialog>
</template>
