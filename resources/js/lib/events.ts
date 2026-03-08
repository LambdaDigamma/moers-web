import { formatDateTime } from '@/lib/date';
import Event = Modules.Events.Data.Event;

export function formatCollectionLabel(collection: string | null | undefined): string | null {
    if (!collection) {
        return null;
    }

    return collection
        .replaceAll('-', ' ')
        .replace(/\b\w/g, (letter) => letter.toUpperCase());
}

export function getEventPrimaryLabel(event: Event): string | null {
    return event.category ?? formatCollectionLabel(event.collection);
}

export function getEventLocationLabel(event: Event): string | null {
    const segments = [event.locationName, event.city].filter((segment): segment is string => Boolean(segment));

    if (segments.length === 0) {
        return null;
    }

    return segments.join(', ');
}

export function getEventAddressLabel(event: Event): string | null {
    const streetLine = event.street;
    const cityLine = [event.postcode, event.city].filter((segment): segment is string => Boolean(segment)).join(' ');

    return [streetLine, cityLine].filter((segment): segment is string => Boolean(segment)).join(', ') || null;
}

export function getEventMapsUrl(event: Event): string | null {
    if (event.latitude != null && event.longitude != null) {
        return `https://www.openstreetmap.org/?mlat=${event.latitude}&mlon=${event.longitude}#map=17/${event.latitude}/${event.longitude}`;
    }

    const query = [event.locationName, event.street, event.postcode, event.city].filter((segment): segment is string => Boolean(segment)).join(', ');

    if (!query) {
        return null;
    }

    return `https://www.openstreetmap.org/search?query=${encodeURIComponent(query)}`;
}

export function buildEventHref(eventId: number, currentUrl?: string): string {
    const href = route('events.show', [eventId]);

    if (!currentUrl) {
        return href;
    }

    return `${href}?back=${encodeURIComponent(currentUrl)}`;
}

export function getEventMonthGroupKey(event: Event): string {
    if (event.startDate == null) {
        return 'undated';
    }

    const date = new Date(event.startDate);

    return `${date.getFullYear()}-${date.getMonth() + 1}`;
}

export function getEventMonthGroupLabel(event: Event): string {
    if (event.startDate == null) {
        return 'Ohne Termin';
    }

    return new Intl.DateTimeFormat(undefined, {
        month: 'long',
        year: 'numeric',
    }).format(new Date(event.startDate));
}

export function getEventDateBadge(event: Event): { weekday: string; day: string; month: string } | null {
    if (event.startDate == null) {
        return null;
    }

    return {
        weekday: formatDateTime(event.startDate, { weekday: 'short' }) ?? '',
        day: formatDateTime(event.startDate, { day: '2-digit' }) ?? '',
        month: formatDateTime(event.startDate, { month: 'short' }) ?? '',
    };
}
