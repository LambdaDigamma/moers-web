import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { Link } from '@inertiajs/react';
import { ArrowUpRight, ChevronLeft } from 'lucide-react';
import { ReactNode } from 'react';

type PostProps = {
    post: {
        id: number;
        title: string;
        summary: string | null;
        published_at: string | null;
        external_href: string | null;
    };
};

const formatDate = (value: string | null) => {
    if (!value) {
        return null;
    }

    return new Intl.DateTimeFormat('de-DE', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(value));
};

function NewsShow({ post }: PostProps) {
    return (
        <>
            <SeoHead
                title={post.title}
                description={post.summary ?? `Aktuelle Meldung aus Moers: ${post.title}.`}
                type="article"
            />

            <PageHeader
                badge="Nachrichten"
                title={post.title}
                description={formatDate(post.published_at) ?? 'Aktuell'}
                actions={
                    <Button
                        asChild
                        variant="outline"
                    >
                        <Link href={route('news.index')}>
                            <ChevronLeft data-icon="inline-start" />
                            Alle Nachrichten
                        </Link>
                    </Button>
                }
            />
            <DefaultContainer className="py-12 md:py-16">
                <article className="flex max-w-3xl flex-col items-start gap-8">
                    <p className="text-muted-foreground text-lg leading-8 whitespace-pre-line">
                        {post.summary || 'Zu diesem Beitrag liegt noch kein ausführlicher Text vor.'}
                    </p>
                    {post.external_href && (
                        <Button
                            asChild
                            variant="outline"
                        >
                            <a
                                href={post.external_href}
                                target="_blank"
                                rel="noreferrer"
                            >
                                Extern weiterlesen
                                <ArrowUpRight data-icon="inline-end" />
                            </a>
                        </Button>
                    )}
                </article>
            </DefaultContainer>
        </>
    );
}

NewsShow.layout = (page: ReactNode) => <AppLayout children={page} />;

export default NewsShow;
