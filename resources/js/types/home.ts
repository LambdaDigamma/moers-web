import { type ParkingAreaSummary } from '@/components/parking-overview-card';

export type HomeStats = {
    upcoming_events: number;
    events_today_and_tomorrow: number;
    news_posts: number;
    rubbish_streets: number;
    parking_spaces: number;
    free_parking_spaces: number;
    open_parking_areas: number;
};

export type HomeEvent = {
    id: number;
    name: string;
    start_date: string | null;
    scheduleDisplay: string;
    showsDateComponent: boolean;
    showsTimeComponent: boolean;
    location: string | null;
    category: string | null;
};

export type HomeEventDayFilter = {
    key: string;
    label: string;
};

export type HomeNewsPost = {
    id: number;
    title: string;
    summary: string | null;
    published_at: string | null;
    external_href: string | null;
    source_name: string | null;
    header_image_url: string | null;
};

export type HomeParkingArea = ParkingAreaSummary;

export type MobileAppLinks = {
    ios_url: string;
    android_url: string;
};
