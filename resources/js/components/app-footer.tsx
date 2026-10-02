import AppLogo from '@/components/app-logo';
import { DefaultContainer } from '@/components/default-container';
import { Link } from '@inertiajs/react';

type FooterLink = {
    label: string;
    href: string;
    isExternal?: boolean;
};

const linkClassName =
    'rounded-sm text-muted-foreground underline-offset-4 transition-colors hover:text-foreground hover:underline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-ring';

const getFooterColumns = (): { title: string; links: FooterLink[] }[] => [
    {
        title: 'Entdecken',
        links: [
            { label: 'Veranstaltungen', href: route('events.index') },
            { label: 'Nachrichten', href: route('news.index') },
            { label: 'Vereine & Organisationen', href: route('organisations.index') },
        ],
    },
    {
        title: 'Services',
        links: [
            { label: 'Abfallkalender', href: route('rubbish.index') },
            { label: 'Parken', href: route('parking-areas.index') },
        ],
    },
    {
        title: 'Rechtliches',
        links: [
            { label: 'Impressum', href: 'https://inventas.io/impressum', isExternal: true },
            { label: 'Datenschutz', href: route('legal.privacy') },
            { label: 'Nutzungsbedingungen', href: route('legal.tac') },
        ],
    },
];

export function AppFooter() {
    return (
        <footer className="border-border bg-background border-t">
            <DefaultContainer className="flex flex-col gap-10 pt-14 pb-10">
                <div className="flex flex-col justify-between gap-10 md:flex-row">
                    <div className="flex max-w-xs flex-col gap-3.5">
                        <div className="flex items-center gap-2.5">
                            <AppLogo />
                        </div>
                        <p className="text-muted-foreground text-sm leading-[22px]">Termine, Nachrichten und Services für die Grafenstadt Moers.</p>
                    </div>

                    <div className="flex flex-wrap gap-10 md:gap-20">
                        {getFooterColumns().map((column) => (
                            <nav
                                key={column.title}
                                aria-label={column.title}
                                className="flex flex-col gap-3 text-sm leading-[18px]"
                            >
                                <span className="text-foreground font-semibold">{column.title}</span>
                                {column.links.map((link) =>
                                    link.isExternal ? (
                                        <a
                                            key={link.label}
                                            href={link.href}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className={linkClassName}
                                        >
                                            {link.label}
                                            <span className="sr-only"> (öffnet in einem neuen Tab)</span>
                                        </a>
                                    ) : (
                                        <Link
                                            key={link.label}
                                            href={link.href}
                                            className={linkClassName}
                                        >
                                            {link.label}
                                        </Link>
                                    ),
                                )}
                            </nav>
                        ))}
                    </div>
                </div>

                <div className="border-border text-muted-foreground flex flex-col gap-2 border-t pt-6 text-[13px] leading-4 sm:flex-row sm:justify-between">
                    <p>&copy; {new Date().getFullYear()} Inventas GmbH</p>
                    <p>Gemacht in Moers</p>
                </div>
            </DefaultContainer>
        </footer>
    );
}
