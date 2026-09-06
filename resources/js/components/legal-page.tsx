import { DefaultContainer } from '@/components/default-container';
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

            <div className="bg-[linear-gradient(180deg,_#fafafa_0%,_#ffffff_18rem)] dark:bg-[linear-gradient(180deg,_#18181b_0%,_#09090b_18rem)]">
                <DefaultContainer className="py-10 sm:py-14 lg:py-20">
                    <header className="max-w-3xl">
                        <p className="text-accent-700 dark:text-accent-400 mb-3 text-sm font-semibold tracking-wide uppercase">Rechtliches</p>
                        <h1 className="text-3xl font-bold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">{title}</h1>
                        <p className="mt-4 max-w-2xl text-base leading-7 text-zinc-600 dark:text-zinc-400">{description}</p>
                        <p className="mt-4 text-sm text-zinc-500 dark:text-zinc-500">
                            <time dateTime="2026-09-06">Stand: 6. September 2026</time>
                        </p>
                    </header>

                    <div className="mt-10 grid items-start gap-10 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-16">
                        <nav
                            aria-label="Inhaltsverzeichnis"
                            className="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm lg:sticky lg:top-6 dark:border-white/10 dark:bg-zinc-900"
                        >
                            <h2 className="text-sm font-semibold text-zinc-950 dark:text-white">Auf dieser Seite</h2>
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

                        <article className="max-w-3xl min-w-0 space-y-10 text-base leading-7 text-zinc-700 dark:text-zinc-300">{children}</article>
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
                className="mb-4 text-2xl font-semibold tracking-tight text-zinc-950 dark:text-white"
            >
                {title}
            </h2>
            <div className="space-y-4">{children}</div>
        </section>
    );
}

export const legalLinkClassName =
    'font-medium text-accent-700 underline decoration-accent-300 underline-offset-4 hover:text-accent-900 focus-visible:rounded-sm focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent-600 dark:text-accent-400 dark:decoration-accent-700 dark:hover:text-accent-300';
