<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed, reactive, onMounted, inject } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { Link2 } from "lucide-vue-next";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Title from "@/Components/Title.vue";
const dayjs = inject("dayjs");
const breadcrumbs = ref([{ title: "Kullanıcılar" }]);
const page = usePage();

// Arama inputu için reactive bir değişken
const searchQuery = ref("");

// Örnek kullanıcı verisi (Bu veriyi props'tan alabilirsiniz)
const users = ref([]);

onMounted(() => {
    users.value = page.props.users;
});

const userPlan = (plan) => {
    switch (plan) {
        case "free":
            return "Ücretsiz Sürüm";
        case "paid":
            return "Ücretli Sürüm";
        case "doctor":
            return "Doktor";
        case "admin":
            return "Admin";
        default:
            return "-";
    }
};

// Kullanıcıları arama query'sine göre filtreleme
const filteredUsers = computed(() => {
    return users.value.filter((user) => {
        const lowercasedQuery = searchQuery.value.toLowerCase();
        return (
            user.name.toLowerCase().includes(lowercasedQuery) ||
            user.email.toLowerCase().includes(lowercasedQuery)
        );
    });
});

const selectedLead = reactive({
    id: null,
});

const handleClickProcess = (id) => {
    selectedLead.id = id;
};
</script>

<template>
    <Head title="Kullanıcılar" />
    <AuthenticatedLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-4">
            <Title text="Kullanıcı Listesi" />

            <!-- TODO: Backend search yapılabilir -->
            <div class="mb-4 mt-4">
                <Label>Kullanıcı Ara</Label>
                <Input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Kullanıcı Ara..."
                    class="border p-2 rounded w-full"
                />
            </div>
            <Table class="border mt-5">
                <TableHeader>
                    <TableRow>
                        <TableHead>Detay</TableHead>
                        <TableHead>Ad Soyad</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Plan</TableHead>
                        <TableHead>Statü</TableHead>
                        <TableHead>Oluşturulma Tarihi</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="user in filteredUsers" :key="user.id">
                        <TableCell>
                            <DropdownMenu as-child>
                                <DropdownMenuTrigger>
                                    <Button
                                        processbutton
                                        size="sm"
                                        @click="handleClickProcess(user.id)"
                                    >
                                        İşlemler<LucideChevronDown />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuItem
                                        :as="Link"
                                        :href="route('users.show', user.id)"
                                        class="cursor-pointer"
                                    >
                                        Görüntüle
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        :as="Link"
                                        :href="route('users.edit', user.id)"
                                        class="cursor-pointer"
                                    >
                                        Düzenle
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                        <TableCell
                            >{{ user.name }} {{ user.surname }}</TableCell
                        >
                        <TableCell>{{ user.email }}</TableCell>
                        <TableCell>{{ userPlan(user.plan) }}</TableCell>
                        <TableCell>{{ user.status === 'aktif' ? 'Aktif' : 'Pasif' }}</TableCell>

                        <TableCell>{{
                            $dayjs(user.created_at).format("DD/MM/YYYY")
                        }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AuthenticatedLayout>
</template>
