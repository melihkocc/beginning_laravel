export const useFileHelpers = () => {
    const formatFileSize = (bytes) => {
        bytes = Number(bytes);

        if (bytes == 0) {
            return '0 Byte';
        } else if (bytes < 1024) {
            return bytes + ' Kb';
        } else if (bytes < 1048576) {
            return (bytes / 1024).toFixed(1) + ' Kb';
        } else if (bytes < 1073741824) {
            return (bytes / 1048576).toFixed(1) + ' Mb';
        } else {
            return (bytes / 1073741824).toFixed(1) + ' Gb';
        }
    };

    return { formatFileSize };
};
