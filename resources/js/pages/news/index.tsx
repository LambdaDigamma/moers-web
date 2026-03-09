import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import { ReactNode } from 'react';

type NewsPost = {
    id: number;
    title: string;
    summary: string | null;
    published_at: string | null;
};

const formatDate = (value: string | null) => {
    if (! value) {
        return 'Neu';
    }

    return new Intl.DateTimeFormat('de-DE', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(new Date(value));
};

function NewsIndex({ posts }: { posts: Paginator<NewsPost> }) {
    return (
        <>
            <Head title="News" />

            <DefaultContainer className="py-10">
                <Card className="py-0">
                    <CardHeader className="border-b py-6">
                        <CardTitle className="text-3xl">News</CardTitle>
                        <CardDescription>Aktuelle Meldungen und Updates aus Moers</CardDescription>
                    </CardHeader>
                    <CardContent className="p-0">
                        {posts.data.length === 0 ? (
                            <div className="px-6 py-10 text-sm text-zinc-500 dark:text-zinc-400">
                                Aktuell sind keine Beiträge veröffentlicht.
                            </div>
                        ) : (
                            <ul className="divide-y divide-zinc-200 dark:divide-white/10">
                                {posts.data.map((post) => (
                                    <li key={post.id}>
                                        <Link
                                            href={route('news.show', [post.id])}
                                            className="flex items-start justify-between gap-4 px-6 py-5 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                        >
                                            <div>
                                                <div className="font-medium text-zinc-950 dark:text-white">{post.title}</div>
                                                <div className="mt-2 max-w-3xl text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                                    {post.summary ?? 'Keine Kurzbeschreibung hinterlegt.'}
                                                </div>
                                                <div className="mt-3 text-xs uppercase tracking-[0.16em] text-zinc-400">
                                                    {formatDate(post.published_at)}
                                                </div>
                                            </div>
                                            <ArrowRight className="mt-1 size-4 shrink-0 text-zinc-400" />
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        )}
                    </CardContent>
                </Card>

                <div className="mt-6">
                    <DefaultPagination paginator={posts} />
                </div>
            </DefaultContainer>
        </>
    );
}

NewsIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default NewsIndex;
