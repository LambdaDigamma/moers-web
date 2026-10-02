import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import type { ReactNode } from 'react';

type LegalSectionLink = {
    id: string;
    label: string;
};

type LegalPageProps = {
    canonicalUrl: string;
    children: ReactNode;
    description: string;
    sections: LegalSectionLink[];
    title: string;
};

export function LegalPage({ canonicalUrl, children, description, sections, title }: LegalPageProps) {
    return (
        <>
            <SeoHead
                title={title}
                description={description}
                canonicalUrl={canonicalUrl}
            />

            <div className="bg-background">
                <PageHeader
                    badge="Rechtliches"
                    title={title}
                    description={description}
                >
                    <p className="text-muted-foreground text-sm">
                        <time dateTime="2026-09-06">Stand: 6. September 2026</time>
                    </p>
                </PageHeader>
                <DefaultContainer className="py-12 md:py-16">
                    <div className="grid items-start gap-10 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-16">
                        <nav
                            aria-label="Inhaltsverzeichnis"
                            className="border-border bg-card rounded-xl border p-5 lg:sticky lg:top-6"
                        >
                            <h2 className="text-foreground text-sm font-semibold">Auf dieser Seite</h2>
                            <ol className="mt-3 space-y-2 text-sm">
                                {sections.map((section, index) => (
                                    <li key={section.id}>
                                        <a
                                            href={`#${section.id}`}
                                            className="hover:text-accent-700 focus-visible:outline-accent-600 dark:hover:text-accent-400 block rounded-sm text-zinc-600 underline-offset-4 hover:underline focus-visible:outline-2 focus-visible:outline-offset-4 dark:text-zinc-400"
                                        >
                                            {index + 1}. {section.label}
                                        </a>
                                    </li>
                                ))}
                            </ol>
                        </nav>

                        <article className="text-muted-foreground max-w-3xl min-w-0 space-y-10 text-base leading-7">{children}</article>
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
}

type LegalSectionProps = {
    children: ReactNode;
    id: string;
    title: string;
};

export function LegalSection({ children, id, title }: LegalSectionProps) {
    return (
        <section
            id={id}
            aria-labelledby={`${id}-title`}
            className="scroll-mt-6"
        >
            <h2
                id={`${id}-title`}
                className="font-display tracking-heading text-foreground mb-4 text-2xl font-semibold"
            >
                {title}
            </h2>
            <div className="space-y-4">{children}</div>
        </section>
    );
}

export const legalLinkClassName =
    'font-medium text-accent-700 underline decoration-accent-300 underline-offset-4 hover:text-accent-900 focus-visible:rounded-sm focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent-600 dark:text-accent-400 dark:decoration-accent-700 dark:hover:text-accent-300';
