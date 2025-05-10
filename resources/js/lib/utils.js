import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function valueUpdater(row, columnId, value) {
    row.getValue = (id) => (id === columnId ? value : row.getValue(id));
}
