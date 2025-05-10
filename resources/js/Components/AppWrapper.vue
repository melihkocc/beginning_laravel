<script setup>
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import {
    SIDEBAR_WIDTH,
    SIDEBAR_WIDTH_ICON,
} from "@/components/ui/sidebar/utils";
import { usePermissions } from "@/composables/permissions";
import { cn } from "@/lib/utils";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { defineProps, onBeforeMount, onMounted, ref } from "vue";
import { route } from "ziggy-js";

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";

import { Button } from "@/components/ui/button";
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from "@/components/ui/collapsible";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Separator } from "@/components/ui/separator";
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarInset,
    SidebarMenu,
    SidebarMenuAction,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
    SidebarRail,
    SidebarTrigger,
} from "@/components/ui/sidebar";
import {
    BadgeCheck,
    Bell,
    BriefcaseBusiness,
    Building,
    Calendar1Icon,
    Check,
    CheckCircle,
    ChevronRight,
    ChevronsUpDown,
    Command,
    Disc,
    File,
    Files,
    FileUp,
    Folder,
    Forward,
    Grid2x2,
    Home,
    LetterText,
    LogOut,
    LucidePaperclip,
    MessageCircle,
    MonitorCog,
    Moon,
    MoreHorizontal,
    Network,
    Settings2,
    ShoppingCart,
    SquarePen,
    Sun,
    Trash2,
    Truck,
    UserCheck,
    UserCircle,
    UserCircle2,
    UserCog2Icon,
} from "lucide-vue-next";

import { useToast } from "@/components/ui/toast/use-toast";
import { useDarkModeStore } from "@/stores/dark-mode";
import { usePage } from "@inertiajs/vue3";
import { storeToRefs } from "pinia";

const page = usePage();
const { can, hasGroupPermission } = usePermissions();
const { toast } = useToast();

const props = defineProps({
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});

// This is sample data.
const data = {
    user: {
        name: "shadcn",
        email: "m@example.com",
        avatar: "/avatars/shadcn.jpg",
    },
    sideNav: [
        {
            type: "single",
            checkPermission: false,
            title: "Anasayfa",
            url: route("dashboard"),
            icon: Grid2x2,
            isActive: page.url === "/dashboard",
        },
        {
            type: "group",
            checkPermission: false,
            title: "Bana Özel",
            items: [
                {
                    type: "single",
                    title: "Takvim",
                    url: "#",
                    icon: Calendar1Icon,
                },
                {
                    type: "single",
                    title: "Mesajlar",
                    url: "#",
                    icon: MessageCircle,
                },
                {
                    type: "single",
                    title: "Bildirimler",
                    url: "#",
                    icon: Bell,
                },
            ],
        },
        {
            type: "group",
            checkPermission: true,
            title: "CRM",
            items: [
                {
                    type: "single",
                    title: "Doktor",
                    url: route("dashboard"),
                    icon: BriefcaseBusiness,
                    isActive: page.url === "/dashboard",
                    hasPermission: page.props.auth.user.plan === "doctor",
                },

                {
                    type: "single",
                    title: "Kadın Cinsel Hastalıklar",
                    url: route("sexually-disease.index"),
                    icon: BriefcaseBusiness,
                    isActive: page.url === "/sexually-disease",
                    hasPermission: (page.props.auth.user.plan === "paid" && page.props.auth.user.gender == 'kadin'),
                },

                {
                    type: "single",
                    title: "Kadın Hastalıkları",
                    url: route("women-disease.index"),
                    icon: BriefcaseBusiness,
                    isActive: page.url === "/women-disease",
                    hasPermission: (page.props.auth.user.plan === "paid" && page.props.auth.user.gender == 'kadin'),
                },

                {
                    type: "single",
                    title: "Talepler",
                    url: route("dashboard"),
                    icon: SquarePen,
                    isActive: page.url === "/demands",
                    hasPermission: can(page.props.auth.user.plan),
                },
                {
                    type: "single",
                    title: "Teklifler",
                    url: route("dashboard"),
                    icon: FileUp,
                    isActive: page.url === "/proposals",
                    hasPermission: can(page.props.auth.user.plan),
                },
                {
                    type: "single",
                    title: "Siparişler",
                    url: route("dashboard"),
                    icon: ShoppingCart,
                    isActive: page.url === "/orders",
                    hasPermission: can(page.props.auth.user.plan),
                },
                {
                    type: "single",
                    title: "Sevkiyatlar",
                    url: "#",
                    icon: Truck,
                },
                {
                    type: "single",
                    title: "Onaylamalar",
                    url: route("dashboard"),
                    icon: CheckCircle,
                    isActive: page.url === "/approvals",
                    hasPermission: can(page.props.auth.user.plan),
                },
            ],
        },
        {
            type: "group",
            checkPermission: true,
            title: "Admin",
            items: [
                {
                    type: "single",
                    title: "Kullanıcılar",
                    url: route("users.index"),
                    icon: BriefcaseBusiness,
                    isActive: page.url === "/users",
                    hasPermission: can(page.props.auth.user.plan),
                },
            ],
        },
    ],
};

const { changeThemeUser } = useDarkModeStore();

const { darkMode } = storeToRefs(useDarkModeStore());

function logout() {
    axios
        .post("/logout")
        .then((data) => {
            console.log("data", data);
        })
        .catch((error) => {
            console.error("Logout işlemi başarısız:", error);
        });
}
</script>

<template>
    <div
        :style="{
            '--sidebar-width': SIDEBAR_WIDTH,
            '--sidebar-width-icon': SIDEBAR_WIDTH_ICON,
        }"
        :class="
            cn(
                'group/sidebar-wrapper flex min-h-svh w-full text-sidebar-foreground has-[[data-variant=inset]]:bg-sidebar'
            )
        "
    >
        <Sidebar collapsible="offcanvas" side="left">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <div class="p-2">Başlık</div>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent>
                <SidebarGroup v-for="item in data.sideNav" :key="item.title">
                    <template v-if="item.type === 'single'">
                        <SidebarMenu>
                            <SidebarMenuItem>
                                <SidebarMenuButton
                                    :as="Link"
                                    :href="item.url"
                                    :data-active="item.isActive"
                                >
                                    <component :is="item.icon" />
                                    <span>{{ item.title }}</span>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </template>
                    <template
                        v-else-if="
                            item.type === 'group' &&
                            hasGroupPermission(item.items)
                        "
                    >
                        <SidebarGroupLabel>{{ item.title }}</SidebarGroupLabel>
                        <SidebarMenu
                            v-for="subItem in item.items"
                            :key="subItem.title"
                        >
                            <Collapsible
                                v-if="subItem.type === 'collapsible'"
                                as-child
                                :default-open="subItem.isActive"
                                class="group/collapsible"
                            >
                                <SidebarMenuItem>
                                    <CollapsibleTrigger as-child>
                                        <SidebarMenuButton
                                            :tooltip="subItem.title"
                                        >
                                            <component :is="subItem.icon" />
                                            <span>{{ subItem.title }}</span>
                                            <ChevronRight
                                                class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                            />
                                        </SidebarMenuButton>
                                    </CollapsibleTrigger>
                                    <CollapsibleContent>
                                        <SidebarMenuSub>
                                            <SidebarMenuSubItem
                                                v-for="subItem2 in subItem.items"
                                                :key="subItem2.title"
                                            >
                                                <SidebarMenuSubButton
                                                    as-child
                                                    v-if="
                                                        subItem2.hasPermission
                                                    "
                                                >
                                                    <a :href="subItem2.url">
                                                        <span>{{
                                                            subItem2.title
                                                        }}</span>
                                                    </a>
                                                </SidebarMenuSubButton>
                                            </SidebarMenuSubItem>
                                        </SidebarMenuSub>
                                    </CollapsibleContent>
                                </SidebarMenuItem>
                            </Collapsible>
                            <SidebarMenuItem v-else>
                                <SidebarMenuButton
                                    :as="Link"
                                    :href="subItem.url"
                                    :data-active="subItem.isActive"
                                    v-if="subItem.hasPermission"
                                >
                                    <component :is="subItem.icon" />
                                    <span>{{ subItem.title }}</span>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </template>
                </SidebarGroup>

                <SidebarGroup>
                    <SidebarMenu v-for="item in data.navMain" :key="item.title">
                        <Collapsible
                            v-if="item?.collapsible"
                            as-child
                            :default-open="item.isActive"
                            class="group/collapsible"
                        >
                            <SidebarMenuItem>
                                <CollapsibleTrigger as-child>
                                    <SidebarMenuButton tooltip="item.title">
                                        <component :is="item.icon" />
                                        <span>{{ item.name }}</span>
                                        <ChevronRight
                                            class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                        />
                                    </SidebarMenuButton>
                                </CollapsibleTrigger>
                                <CollapsibleContent>
                                    <SidebarMenuSub>
                                        <SidebarMenuSubItem
                                            v-for="subItem in item.items"
                                            :key="subItem.title"
                                        >
                                            <SidebarMenuSubButton as-child>
                                                <a :href="subItem.url">
                                                    <span>{{
                                                        subItem.title
                                                    }}</span>
                                                </a>
                                            </SidebarMenuSubButton>
                                        </SidebarMenuSubItem>
                                    </SidebarMenuSub>
                                </CollapsibleContent>
                            </SidebarMenuItem>
                        </Collapsible>
                        <SidebarMenuItem v-else>
                            <SidebarMenuButton>
                                <component :is="item.icon" />
                                <span>{{ item.name }}</span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroup>

                <SidebarGroup v-if="false">
                    <SidebarGroupLabel>Platform</SidebarGroupLabel>
                    <SidebarMenu>
                        <Collapsible
                            v-for="item in data.navMain ?? []"
                            :key="item.title"
                            as-child
                            :default-open="item.isActive"
                            class="group/collapsible"
                        >
                            <SidebarMenuItem>
                                <CollapsibleTrigger as-child>
                                    <SidebarMenuButton tooltip="item.title">
                                        <component :is="item.icon" />
                                        <span>{{ item.title }}</span>
                                        <ChevronRight
                                            class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                        />
                                    </SidebarMenuButton>
                                </CollapsibleTrigger>
                                <CollapsibleContent>
                                    <SidebarMenuSub>
                                        <SidebarMenuSubItem
                                            v-for="subItem in item.items"
                                            :key="subItem.title"
                                        >
                                            <SidebarMenuSubButton as-child>
                                                <a :href="subItem.url">
                                                    <span>{{
                                                        subItem.title
                                                    }}</span>
                                                </a>
                                            </SidebarMenuSubButton>
                                        </SidebarMenuSubItem>
                                    </SidebarMenuSub>
                                </CollapsibleContent>
                            </SidebarMenuItem>
                        </Collapsible>
                    </SidebarMenu>
                </SidebarGroup>

                <SidebarGroup
                    v-if="false"
                    class="group-data-[collapsible=icon]:hidden"
                >
                    <SidebarGroupLabel>Projects</SidebarGroupLabel>
                    <SidebarMenu>
                        <SidebarMenuItem
                            v-for="item in data.projects"
                            :key="item.name"
                        >
                            <SidebarMenuButton as-child>
                                <a :href="item.url">
                                    <component :is="item.icon" />
                                    <span>{{ item.name }}</span>
                                </a>
                            </SidebarMenuButton>
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <SidebarMenuAction show-on-hover>
                                        <MoreHorizontal />
                                        <span class="sr-only">More</span>
                                    </SidebarMenuAction>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    class="w-48 rounded-lg"
                                    side="bottom"
                                    align="end"
                                >
                                    <DropdownMenuItem>
                                        <Folder class="text-muted-foreground" />
                                        <span>View Project</span>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <Forward
                                            class="text-muted-foreground"
                                        />
                                        <span>Share Project</span>
                                    </DropdownMenuItem>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem>
                                        <Trash2 class="text-muted-foreground" />
                                        <span>Delete Project</span>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </SidebarMenuItem>
                        <SidebarMenuItem>
                            <SidebarMenuButton
                                class="text-sidebar-foreground/70"
                            >
                                <MoreHorizontal
                                    class="text-sidebar-foreground/70"
                                />
                                <span>More</span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroup>
            </SidebarContent>
            <SidebarFooter>
                <div
                    v-if="actingAsUser"
                    class="mb-4 rounded-lg border-l-4 border-yellow-500 bg-yellow-100 p-4 dark:bg-yellow-700"
                >
                    <p class="text-sm text-yellow-800 dark:text-yellow-100">
                        <strong>Dikkat!</strong> Şu an
                        <span class="font-semibold"
                            >{{ actingAsUser.name }}
                            {{ actingAsUser.surname }}</span
                        >
                        adına işlem yapmaktasınız!
                    </p>
                </div>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <SidebarMenuButton
                                    size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                                >
                                    <Avatar class="h-8 w-8 rounded-lg">
                                        <AvatarFallback class="rounded-lg">
                                            {{
                                                $page.props.auth.user.name[0] +
                                                $page.props.auth.user.surname[0]
                                            }}
                                        </AvatarFallback>
                                    </Avatar>
                                    <div
                                        class="grid flex-1 text-left text-sm leading-tight"
                                    >
                                        <span class="truncate font-semibold">{{
                                            [
                                                $page.props.auth.user.name,
                                                $page.props.auth.user.surname,
                                            ].join(" ")
                                        }}</span>
                                        <span class="truncate text-xs">{{
                                            $page.props.auth.user.email
                                        }}</span>
                                    </div>
                                    <ChevronsUpDown class="ml-auto size-4" />
                                </SidebarMenuButton>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                                side="bottom"
                                align="end"
                                :side-offset="4"
                            >
                                <DropdownMenuLabel class="p-0 font-normal">
                                    <div
                                        class="flex items-center gap-2 px-1 py-1.5 text-left text-sm"
                                    >
                                        <Avatar class="h-8 w-8 rounded-lg">
                                            <AvatarFallback class="rounded-lg">
                                                {{
                                                    $page.props.auth.user
                                                        .name[0]
                                                }}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div
                                            class="grid flex-1 text-left text-sm leading-tight"
                                        >
                                            <span
                                                class="truncate font-semibold"
                                            >
                                                {{
                                                    [
                                                        $page.props.auth.user
                                                            .name,
                                                        $page.props.auth.user
                                                            .surname,
                                                    ].join(" ")
                                                }}
                                            </span>
                                            <span class="truncate text-xs">{{
                                                $page.props.auth.user.email
                                            }}</span>
                                        </div>
                                    </div>
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem
                                        :as="Link"
                                        class="w-full cursor-pointer"
                                        :href="route('profile.edit')"
                                    >
                                        <BadgeCheck />
                                        Hesabım
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                                <DropdownMenuSeparator />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem
                                        :as="Link"
                                        class="w-full cursor-pointer"
                                        :href="route('logout')"
                                        method="post"
                                    >
                                        <LogOut />
                                        Oturumu kapat
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarFooter>
            <SidebarRail />
        </Sidebar>
        <SidebarInset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12"
            >
                <div
                    class="flex w-full items-center justify-between gap-2 px-4"
                >
                    <div class="flex items-center">
                        <SidebarTrigger class="-ml-1" />
                        <Separator orientation="vertical" class="mr-2 h-4" />
                        <Breadcrumb>
                            <BreadcrumbList>
                                <BreadcrumbItem>
                                    <BreadcrumbLink :href="route('dashboard')">
                                        <span class="sr-only">Dashboard</span>
                                        <Home class="size-4" />
                                    </BreadcrumbLink>
                                </BreadcrumbItem>
                                <template
                                    v-for="(
                                        breadcrumb, index
                                    ) in props.breadcrumbs"
                                    :key="index"
                                >
                                    <BreadcrumbSeparator
                                        :class="{
                                            'hidden md:block':
                                                index <
                                                props.breadcrumbs.length - 1,
                                        }"
                                    />
                                    <BreadcrumbItem
                                        :class="{
                                            'hidden md:block':
                                                index <
                                                props.breadcrumbs.length - 1,
                                        }"
                                    >
                                        <BreadcrumbLink
                                            :href="breadcrumb.route"
                                        >
                                            {{ breadcrumb.title }}
                                        </BreadcrumbLink>
                                    </BreadcrumbItem>
                                </template>
                            </BreadcrumbList>
                        </Breadcrumb>
                    </div>
                    <div class="flex items-center">
                        <!-- dark mode dropdown -->
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <div class="rounded-lg">
                                    <Button variant="ghost">
                                        <Sun />
                                        <span class="sr-only rounded-lg">
                                            {{
                                                $page.props.auth.user.name[0] +
                                                $page.props.auth.user.surname[0]
                                            }}
                                        </span>
                                    </Button>
                                </div>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                class="w-[--radix-dropdown-menu-trigger-width] min-w-36 rounded-lg"
                                side="bottom"
                                align="end"
                                :side-offset="4"
                            >
                                <DropdownMenuLabel
                                    class="sr-only p-0 font-normal"
                                >
                                    <div
                                        class="flex items-center gap-2 px-1 py-1.5 text-left text-sm"
                                    >
                                        <span>Dark mode</span>
                                    </div>
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator class="sr-only" />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem
                                        :as="Button"
                                        variant="ghost"
                                        class="w-full cursor-pointer justify-start"
                                        @click.prevent="changeThemeUser('dark')"
                                    >
                                        <Moon />
                                        Dark
                                        <span
                                            v-if="darkMode == 'dark'"
                                            class="ml-auto"
                                        >
                                            <Check />
                                        </span>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        :as="Button"
                                        variant="ghost"
                                        class="w-full cursor-pointer justify-start"
                                        @click.prevent="
                                            changeThemeUser('light')
                                        "
                                    >
                                        <Sun />
                                        Light
                                        <span
                                            v-if="darkMode == 'light'"
                                            class="ml-auto"
                                        >
                                            <Check />
                                        </span>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        :as="Button"
                                        variant="ghost"
                                        class="w-full cursor-pointer justify-start"
                                        @click.prevent="changeThemeUser('auto')"
                                    >
                                        <MonitorCog />
                                        Auto
                                        <span
                                            v-if="darkMode == 'auto'"
                                            class="ml-auto"
                                        >
                                            <Check />
                                        </span>
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>
            </header>
            <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
                <slot name="page" />
            </div>
        </SidebarInset>
    </div>
</template>
