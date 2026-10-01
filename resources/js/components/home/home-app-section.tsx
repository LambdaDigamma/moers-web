import { DefaultContainer } from '@/components/default-container';
import { MobileAppBadge } from '@/components/mobile-app-badge';
import { type MobileAppLinks } from '@/types/home';
import { Bell, CalendarRange, CircleParking, Newspaper, Radio, Trash2, type LucideIcon } from 'lucide-react';

const features: { title: string; description: string; icon: LucideIcon }[] = [
    { title: 'Abfallkalender', description: 'Straße wählen und am Vorabend an die Abholung erinnert werden.', icon: Trash2 },
    { title: 'Live-Parkdaten', description: 'Freie Plätze in allen Parkhäusern der Innenstadt, in Echtzeit.', icon: CircleParking },
    { title: 'Stadt-News', description: 'Meldungen der Stadtverwaltung und lokaler Medien an einem Ort.', icon: Newspaper },
    { title: 'Veranstaltungen', description: 'Konzerte, Märkte und Vereinstermine – nach Tag und Thema gefiltert.', icon: CalendarRange },
    { title: 'Radio Moers', description: 'Den Lokalsender direkt in der App hören, egal wo du bist.', icon: Radio },
    { title: 'Erinnerungen', description: 'Push-Hinweise für Abfuhr, Lieblingstermine und wichtige Meldungen.', icon: Bell },
];

const phonePreviewRows = [
    { caption: 'Homberger Straße', title: 'Restmüll', value: 'Morgen' },
    { caption: 'Parkhaus Kastell', title: 'Geöffnet', value: '128 frei' },
    { caption: 'Kastellplatz · 14:00', title: 'Herbstkirmes', value: '3. Okt.' },
];

function PhonePreview() {
    return (
        <div
            aria-hidden="true"
            className="border-hero-border bg-graphit-950 hidden h-[400px] w-[300px] shrink-0 flex-col self-end rounded-t-[44px] border border-b-0 px-3 pt-3 shadow-[0_-20px_60px_rgb(0_0_0/0.35)] lg:flex"
        >
            <div className="bg-muted flex flex-1 flex-col gap-3 rounded-t-[34px] px-4 pt-11">
                <div className="flex items-center gap-2">
                    <span className="bg-accent-500 size-1.5 rounded-full" />
                    <span className="text-muted-foreground text-[11px] leading-[14px] font-semibold tracking-wider uppercase">
                        Donnerstag, 1. Okt.
                    </span>
                </div>
                <span className="font-display text-foreground text-[26px] leading-7 font-semibold tracking-[-0.03em]">Guten Abend</span>
                {phonePreviewRows.map((row) => (
                    <div
                        key={row.title}
                        className="border-border bg-card flex items-center justify-between rounded-xl border p-3.5"
                    >
                        <div className="flex flex-col gap-0.5">
                            <span className="text-muted-foreground text-[11px] leading-[14px]">{row.caption}</span>
                            <span className="text-foreground text-sm leading-[18px] font-semibold">{row.title}</span>
                        </div>
                        <span className="font-display text-foreground text-[17px] leading-[22px] font-semibold">{row.value}</span>
                    </div>
                ))}
            </div>
        </div>
    );
}

export function HomeAppSection({ mobileApps }: { mobileApps: MobileAppLinks }) {
    return (
        <section className="bg-background">
            <DefaultContainer className="grid grid-cols-1 gap-14 pt-24 pb-24 md:pt-28 lg:grid-cols-[440px_minmax(0,1fr)] lg:gap-24">
                <div className="flex flex-col gap-5">
                    <span className="text-eyebrow text-accent-700 dark:text-accent-400">Die App</span>
                    <h2 className="font-display tracking-display text-4xl leading-[1.08] font-semibold md:text-5xl md:leading-[52px]">
                        Deine Stadt.
                        <br />
                        Deine App.
                    </h2>
                    <p className="text-muted-foreground text-[17px] leading-7">
                        Mein Moers bündelt die wichtigsten Services der Stadt – gemacht für den schnellen Blick unterwegs. Kostenlos und ohne Werbung.
                    </p>
                </div>

                <ul className="grid gap-x-12 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                    {features.map((feature) => (
                        <li
                            key={feature.title}
                            className="border-border flex flex-col gap-3.5 border-t pt-6"
                        >
                            <feature.icon
                                className="text-foreground size-6"
                                strokeWidth={1.75}
                            />
                            <h3 className="font-display tracking-title text-xl leading-6 font-semibold">{feature.title}</h3>
                            <p className="text-muted-foreground text-[15px] leading-6">{feature.description}</p>
                        </li>
                    ))}
                </ul>
            </DefaultContainer>

            <DefaultContainer className="pb-24">
                <div className="bg-hero-glow-side text-hero-foreground relative flex items-center justify-between gap-12 overflow-hidden rounded-2xl px-8 pt-14 md:px-[72px] lg:h-[440px] lg:pt-0">
                    <div className="flex max-w-[520px] flex-col gap-5 pb-14 lg:pb-0">
                        <h2 className="font-display tracking-display text-4xl leading-[1.08] font-semibold md:text-5xl md:leading-[52px]">
                            Moers in der Hosentasche.
                        </h2>
                        <p className="text-hero-muted text-[17px] leading-7">
                            Lade dir Mein Moers kostenlos für iPhone und Android – mit Erinnerungen für deine Abfuhrtermine.
                        </p>
                        <div className="flex flex-wrap items-center gap-3 pt-2">
                            <MobileAppBadge
                                href={mobileApps.ios_url}
                                platform="ios"
                            />
                            <MobileAppBadge
                                href={mobileApps.android_url}
                                platform="android"
                            />
                        </div>
                    </div>
                    <PhonePreview />
                </div>
            </DefaultContainer>
        </section>
    );
}
