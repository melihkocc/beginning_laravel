import { usePage } from '@inertiajs/vue3';

export const usePermissions = () => {
    let permissions = usePage().props?.auth?.permissions ?? [];

    if (!permissions) {
        permissions = usePage().props?.partner?.permissions ?? [];
    }
    const can = (permission) => {
        return permissions.includes(permission);
    };

    const hasGroupPermission = (items) => {
        return items.some((item) => {
            return item.hasPermission;
        });
    };

    return { can, hasGroupPermission };
};
