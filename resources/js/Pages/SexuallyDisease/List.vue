<script setup>
import Title from "@/Components/Title.vue";
import Button from "@/components/ui/button/Button.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { SaveIcon } from "lucide-vue-next";
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
const breadcrumbs = ref([{ title: "Cinsel Hastalık Kayıtlarınız" }]);

const { props } = usePage();

console.log(props);

// Örnek kullanıcı verisi (Bu veriyi props'tan alabilirsiniz)
const sexuallyDiseases = ref([]);

onMounted(() => {
    sexuallyDiseases.value = props.sexuallyDiseases;
});

const selectedData = reactive({
    id: null,
});

const handleClickProcess = (id) => {
    selectedData.id = id;
};
</script>

<template>
    <Head title="Cinsel Hastalık Kayıtlarınız" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div><Title text="Cinsel Hastalık Kayıtlarınız" /></div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center"
                >
                    <Link :href="route('sexually-disease.create')"
                        ><Button processbutton><SaveIcon /> Ekle</Button></Link
                    >
                </div>
            </div>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Detay</TableHead>
                        <TableHead>ID</TableHead>
                        <TableHead>Sonuç</TableHead>
                        <TableHead>Oluşturulma Tarihi</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="data in sexuallyDiseases" :key="data.id">
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
                                        :href="route('sexually-disease.show', data.id)"
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
    </AuthenticatedLayout>
</template>
