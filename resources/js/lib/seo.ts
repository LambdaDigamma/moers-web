export const appName = import.meta.env.VITE_APP_NAME || 'Mein Moers';

export function formatPageTitle(title?: string): string {
    const normalizedTitle = title?.trim();

    if (!normalizedTitle || normalizedTitle === appName) {
        return appName;
    }

    return `${normalizedTitle} - ${appName}`;
}
