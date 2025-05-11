<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted, reactive, ref } from "vue";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Link2 } from "lucide-vue-next";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Head, Link, usePage } from "@inertiajs/vue3";
const breadcrumbs = ref([{ title: "Hasta Talepleri" }]);

const { props } = usePage();
// Örnek kullanıcı verisi (Bu veriyi props'tan alabilirsiniz)
const helps = ref([]);
console.log(props);
onMounted(() => {
    helps.value = props.helps;
});

const selectedData = reactive({
    id: null,
});

const handleClickProcess = (id) => {
    selectedData.id = id;
};
</script>

<template>
    <Head title="Hasta Talepleri" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div><Title text="Hasta Talepleri" /></div>
            </div>
        </div>
        <Table class="border mt-5">
            <TableHeader>
                <TableRow>
                    <TableHead>Detay</TableHead>
                    <TableHead>Randevu Bekleniyor Mu</TableHead>

                    <TableHead>ID</TableHead>
                    <TableHead>Hasta</TableHead>
                    <TableHead>Oluşturulma Tarihi</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="data in helps" :key="data.id">
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
                                    :href="route('help-show-doctor', data.id)"
                                    class="cursor-pointer"
                                >
                                    Görüntüle
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </TableCell>
                    <TableCell>
                        {{ data.meeting_status == "Bekleniyor" ? "✔️" : "❌" }}
                    </TableCell>
                    <TableCell>{{ data.id }}</TableCell>
                    <TableCell
                        >{{ data.patient.name }}
                        {{ data.patient.surname }}</TableCell
                    >
                    <TableCell>{{
                        $dayjs(data.created_at).format("DD/MM/YYYY")
                    }}</TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </AuthenticatedLayout>
</template>
