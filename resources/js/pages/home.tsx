import { HomeAppSection } from '@/components/home/home-app-section';
import { HomeEventsSection } from '@/components/home/home-events-section';
import { HomeHero } from '@/components/home/home-hero';
import { HomeNewsSection } from '@/components/home/home-news-section';
import { SeoHead } from '@/components/seo-head';
import AppLayout from '@/layouts/app-layout';
import { type HomeEvent, type HomeEventDayFilter, type HomeNewsPost, type HomeParkingArea, type HomeStats, type MobileAppLinks } from '@/types/home';
import { ReactNode } from 'react';

type HomeProps = {
    stats: HomeStats;
    upcomingEvents: HomeEvent[];
    eventDayFilters: HomeEventDayFilter[];
    selectedEventDay: string;
    latestNews: HomeNewsPost[];
    parkingAreas: HomeParkingArea[];
    mobileApps: MobileAppLinks;
};

function Home({ stats, upcomingEvents, eventDayFilters, selectedEventDay, latestNews, parkingAreas, mobileApps }: HomeProps) {
    return (
        <>
            <SeoHead
                title="Moers digital – Termine und Services"
                description="Mein Moers bündelt Veranstaltungen, News, Parkplätze, Organisationen und den Abfallkalender für die Stadt Moers."
            />

            <div className="bg-background flex flex-col">
                <HomeHero
                    stats={stats}
                    parkingAreas={parkingAreas}
                />
                <HomeEventsSection
                    events={upcomingEvents}
                    dayFilters={eventDayFilters}
                    selectedEventDay={selectedEventDay}
                    parkingAreas={parkingAreas}
                    parkingSpaces={stats.parking_spaces}
                />
                <HomeNewsSection posts={latestNews} />
                <HomeAppSection mobileApps={mobileApps} />
            </div>
        </>
    );
}

Home.layout = (page: ReactNode) => (
    <AppLayout
        headerVariant="hero"
        children={page}
    />
);

export default Home;
