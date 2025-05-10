<script setup>
import Button from "@/components/ui/button/Button.vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Üyelik Onayı" />
    <div
        class="flex min-h-screen flex-col items-center justify-center space-y-4"
    >
        <Card class="w-ful max-w-xl">
            <CardHeader>
                <CardTitle>Üyelik onayı bekleniyor!</CardTitle>
            </CardHeader>
            <CardContent>
                Kayıt işlemini başarıyla tamamladınız. Hesabınızı
                kullanabilmeniz için yönetici onayı beklenmektedir. Onay sonrası
                uygulamaya giriş yapabilirsiniz.
            </CardContent>
            <div class="flex items-center justify-center w-full my-3">
                <Link method="post" :href="route('logout')"><Button processbutton>Çıkış Yap</Button></Link>
            </div>
        </Card>
    </div>
</template>
