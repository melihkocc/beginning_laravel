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
const breadcrumbs = ref([{ title: "Yardım Taleplerim" }]);

const { props } = usePage();

// Örnek kullanıcı verisi (Bu veriyi props'tan alabilirsiniz)
const helps = ref([]);

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
    <Head title="Yardım Taleplerim" />

    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                <div><Title text="Yardım Taleplerim" /></div>
                <div
                    class="flex lg:justify-end md:justify-end justify-start items-center"
                >
                    <Link :href="route('find-doctor.index')"
                        ><Button processbutton><SaveIcon /> Ekle</Button></Link
                    >
                </div>
            </div>
            <Table class="border mt-5">
                <TableHeader>
                    <TableRow>
                        <TableHead>Detay</TableHead>
                        <TableHead>ID</TableHead>
                        <TableHead>Doktor</TableHead>
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
                                        :href="
                                            route(
                                                'help-show-disease.index',
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
                        <TableCell
                            >{{ data.doctor.name }}
                            {{ data.doctor.surname }}</TableCell
                        >
                        <TableCell>{{
                            $dayjs(data.created_at).format("DD/MM/YYYY")
                        }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AuthenticatedLayout>
</template>
