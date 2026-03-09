import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ArrowRight, ArrowUpRight, Newspaper } from 'lucide-react';
import { ReactNode } from 'react';

type NewsPost = {
    id: number;
    title: string;
    summary: string | null;
    published_at: string | null;
    external_href: string | null;
    source_name: string | null;
    header_image_url: string | null;
};

const formatDate = (value: string | null) => {
    if (!value) {
        return 'Neu';
    }

    return new Intl.DateTimeFormat('de-DE', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(new Date(value));
};

function NewsCard({ post }: { post: NewsPost }) {
    const isExternal = post.external_href !== null;
    const content = (
        <Card className="group h-full overflow-hidden border-zinc-200/80 py-0 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg dark:border-white/10 dark:bg-zinc-950">
            <div className="relative">
                {post.header_image_url ? (
                    <img
                        src={post.header_image_url}
                        alt={post.title}
                        className="aspect-[16/9] w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                    />
                ) : (
                    <div className="flex aspect-[16/9] items-center justify-center bg-linear-to-br from-sky-100 via-white to-amber-100 dark:from-sky-500/15 dark:via-zinc-950 dark:to-amber-500/10">
                        <div className="flex size-16 items-center justify-center rounded-full border border-white/70 bg-white/80 shadow-sm dark:border-white/10 dark:bg-white/10">
                            <Newspaper className="size-7 text-sky-700 dark:text-sky-300" />
                        </div>
                    </div>
                )}
                <div className="absolute top-4 left-4 flex flex-wrap gap-2">
                    {post.source_name ? <Badge className="bg-white/90 text-zinc-900 hover:bg-white">{post.source_name}</Badge> : null}
                    {isExternal ? (
                        <Badge
                            variant="outline"
                            className="border-white/70 bg-zinc-950/65 text-white backdrop-blur"
                        >
                            Externer Link
                        </Badge>
                    ) : null}
                </div>
            </div>

            <CardContent className="flex h-full flex-col gap-4 p-6">
                <div className="text-xs font-medium tracking-[0.18em] text-zinc-400 uppercase">{formatDate(post.published_at)}</div>
                <div className="space-y-3">
                    <h2 className="text-xl leading-snug font-semibold text-zinc-950 dark:text-white">{post.title}</h2>
                    <p className="line-clamp-4 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                        {post.summary ?? 'Zur Meldung beim Originalanbieter wechseln.'}
                    </p>
                </div>
                <div className="mt-auto flex items-center gap-2 text-sm font-medium text-sky-700 dark:text-sky-300">
                    <span>{isExternal ? 'Originalbeitrag öffnen' : 'Beitrag ansehen'}</span>
                    {isExternal ? <ArrowUpRight className="size-4" /> : <ArrowRight className="size-4" />}
                </div>
            </CardContent>
        </Card>
    );

    if (isExternal) {
        return (
            <a
                href={post.external_href ?? '#'}
                target="_blank"
                rel="noreferrer"
                className="block h-full"
            >
                {content}
            </a>
        );
    }

    return (
        <Link
            href={route('news.show', [post.id])}
            className="block h-full"
        >
            {content}
        </Link>
    );
}

function NewsIndex({ posts }: { posts: Paginator<NewsPost> }) {
    return (
        <>
            <Head title="News" />

            <DefaultContainer className="space-y-8 py-10">
                <section className="overflow-hidden rounded-[2rem] border border-zinc-200 bg-linear-to-br from-sky-50 via-white to-amber-50 p-6 shadow-sm dark:border-white/10 dark:from-sky-500/10 dark:via-zinc-950 dark:to-amber-500/10">
                    <div className="max-w-3xl space-y-4">
                        <div className="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-white/90 px-3 py-1 text-xs font-medium tracking-[0.18em] text-sky-800 uppercase shadow-sm dark:border-sky-500/20 dark:bg-white/5 dark:text-sky-200">
                            <Newspaper className="size-3.5" />
                            Lokale Berichterstattung
                        </div>
                        <div className="space-y-2">
                            <h1 className="text-3xl font-semibold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">
                                News aus und über Moers
                            </h1>
                            <p className="max-w-2xl text-sm leading-7 text-zinc-600 dark:text-zinc-300">
                                Aggregiert aus regionalen Quellen. Die Beiträge bleiben bei den Originalanbietern, werden hier aber gesammelt, datiert
                                und mit Vorschau sichtbar gemacht.
                            </p>
                        </div>
                    </div>
                </section>

                {posts.data.length === 0 ? (
                    <Card className="border-dashed py-0">
                        <CardContent className="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            Aktuell sind keine Beiträge veröffentlicht.
                        </CardContent>
                    </Card>
                ) : (
                    <section className="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        {posts.data.map((post) => (
                            <NewsCard
                                key={post.id}
                                post={post}
                            />
                        ))}
                    </section>
                )}

                <div className="pt-2">
                    <DefaultPagination paginator={posts} />
                </div>
            </DefaultContainer>
        </>
    );
}

NewsIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default NewsIndex;
