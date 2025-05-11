<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import Label from "@/components/ui/label/Label.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { Check, MessageCircle } from "lucide-vue-next";
import { inject, onMounted, ref } from "vue";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/components/ui/sheet";
import { Link2 } from "lucide-vue-next";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import Calendar from "@/components/ui/calendar/Calendar.vue";

const dayjs = inject("dayjs");

const breadcrumbs = ref([
    {
        title: "Talepler",
        route: route("help-doctor.index"),
    },
    {
        title: "Talep Detay Görüntüle",
    },
]);

const { props } = usePage();
console.log(props);

const form = useForm({
    doctor_description: props.help.doctor_description,
});

const activate = () => {
    form.post(route("help-activate-doctor", props.help.id));
};

const sexuallyDiseases = ref([]);
const womenDiseases = ref([]);

onMounted(() => {
    sexuallyDiseases.value = props.sexuallyDiseases;
    womenDiseases.value = props.womenDiseases;
});

const meetForm = useForm({});

const submitMeet = () => {
    meetForm.post(route("help-meet-submit", props.help.id), {
        onSuccess: () => {
            meetForm.reset();
        },
    });
};
</script>

<template>
    <Head title="Talepler" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-6 space-y-8">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6">
                <div>
                    <Title text="Talep Detay Görüntüle" />
                    <div class="mt-2 text-sm">
                        Oluşturulma Tarihi :
                        {{ $dayjs(props.help.created_at).format("DD/MM/YYYY") }}
                    </div>
                </div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center gap-5"
                >
                    <div
                        v-if="props.help.status"
                        class="flex lg:justify-end md:justify-end justify-start items-center"
                    >
                        <Link :href="route('help-message.show', props.help.id)"
                            ><Button processbutton>
                                <MessageCircle /> Mesajlaş</Button
                            ></Link
                        >
                    </div>
                    <div
                        v-else
                        class="flex lg:justify-end md:justify-end justify-start items-center"
                    >
                        <Button @click="activate" processbutton>
                            <Check /> Talebi Onayla</Button
                        >
                    </div>
                    <div v-if="props.help.meeting_status == 'Bekleniyor'">
                        <Sheet>
                            <SheetTrigger>
                                <Button processbutton
                                    ><Check /> Randevu Onayla</Button
                                >
                            </SheetTrigger>
                            <SheetContent>
                                <SheetHeader>
                                    <SheetTitle>Randevu Onayla</SheetTitle>
                                    <SheetDescription>
                                        {{ props.help.patient.name }}
                                        {{ props.help.patient.surname }} adlı
                                        hastanın randevusunu onaylıyorsunuz.
                                    </SheetDescription>
                                    <div>
                                        <Label>Randevu Zamanı</Label>
                                        <div class="text-sm font-semibold">
                                            {{
                                                dayjs(
                                                    props.help.meeting_date
                                                ).format("DD/MM/YYYY HH:mm")
                                            }}
                                        </div>
                                    </div>
                                    <Button
                                        @click="submitMeet"
                                        class="mt-3"
                                        processbutton
                                    >
                                        <Check /> Onayla</Button
                                    >
                                </SheetHeader>
                            </SheetContent>
                        </Sheet>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-8">
                <!-- Patient Details -->
                <div
                    class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6 dark:bg-gray-900 dark:border-gray-700"
                >
                    <h3 class="text-lg font-bold mb-4">Hasta Bilgileri</h3>
                    <ul class="space-y-3">
                        <li class="">
                            <strong>Ad Soyad:</strong>
                            {{ props.help.patient.name }}
                            {{ props.help.patient.surname }}
                        </li>
                        <li class="">
                            <strong>Cinsiyet:</strong>
                            {{
                                props.help.patient.gender == "erkek"
                                    ? "Erkek"
                                    : "Kadın"
                            }}
                        </li>
                        <li class="">
                            <strong>E-posta:</strong>
                            {{ props.help.patient.email }}
                        </li>
                    </ul>
                </div>
                <!-- Complaint Description -->
                <div
                    class="bg-gray-50 border border-gray-300 rounded-lg shadow-lg p-6 dark:bg-gray-900 dark:border-gray-700"
                >
                    <h3 class="text-lg font-bold mb-4">Şikayet Açıklaması</h3>
                    <p class="leading-relaxed">
                        {{ props.help.complaint_description }}
                    </p>
                </div>
            </div>

            <div>
                <div class="mt-4">
                    <Label
                        >Doktor Önerisi
                        <span class="text-red-500">*</span></Label
                    >
                    <Textarea
                        id="address"
                        type="text"
                        class="mt-1 block w-full !opacity-100 !cursor-default"
                        v-model="form.doctor_description"
                        placeholder="Doktor Önerisi"
                        autofocus
                        autocomplete="address"
                        :disabled="props.help.doctor_description"
                        rows="9"
                        maxlength="1000"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.doctor_description"
                    />
                </div>
            </div>
            <div>
                <div class="text-xl font-semibold">Hasta Sonuçları</div>
                <div class="mt-5 font-semibold">
                    Cinsel Yolla Bulaşan Hastalıklar
                </div>
                <Table class="border mt-5">
                    <TableHeader>
                        <TableRow>
                            <TableHead>Detay</TableHead>
                            <TableHead>ID</TableHead>
                            <TableHead>Sonuç</TableHead>
                            <TableHead>Oluşturulma Tarihi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="data in sexuallyDiseases"
                            :key="data.id"
                        >
                            <TableCell>
                                <DropdownMenu as-child>
                                    <DropdownMenuTrigger>
                                        <Button
                                            processbutton
                                            size="sm"
                                            @click="handleClickProcess(data.id)"
                                        >
                                            İşlemler<LucideChevronDown />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem
                                            :as="Link"
                                            :href="
                                                route(
                                                    'sexually-disease.show',
                                                    data.id
                                                )
                                            "
                                            class="cursor-pointer"
                                        >
                                            Görüntüle
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                            <TableCell>{{ data.id }}</TableCell>
                            <TableCell>{{ data.result }}</TableCell>
                            <TableCell>{{
                                $dayjs(data.created_at).format("DD/MM/YYYY")
                            }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <div class="font-semibold mt-5">Kadın Hastalıkları</div>
                <Table class="border mt-5">
                    <TableHeader>
                        <TableRow>
                            <TableHead>Detay</TableHead>
                            <TableHead>ID</TableHead>
                            <TableHead>Sonuç</TableHead>
                            <TableHead>Oluşturulma Tarihi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="data in womenDiseases" :key="data.id">
                            <TableCell>
                                <DropdownMenu as-child>
                                    <DropdownMenuTrigger>
                                        <Button
                                            processbutton
                                            size="sm"
                                            @click="handleClickProcess(data.id)"
                                        >
                                            İşlemler<LucideChevronDown />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem
                                            :as="Link"
                                            :href="
                                                route(
                                                    'women-disease.show',
                                                    data.id
                                                )
                                            "
                                            class="cursor-pointer"
                                        >
                                            Görüntüle
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                            <TableCell>{{ data.id }}</TableCell>
                            <TableCell>{{ data.result }}</TableCell>
                            <TableCell>{{
                                $dayjs(data.created_at).format("DD/MM/YYYY")
                            }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
