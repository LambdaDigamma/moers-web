import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
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
            <Head title={post.title} />

            <DefaultContainer className="py-10">
                <div className="mb-6">
                    <Button
                        asChild
                        variant="ghost"
                        className="px-0"
                    >
                        <Link href={route('news.index')}>
                            <ChevronLeft className="size-4" />
                            Zurück zu den News
                        </Link>
                    </Button>
                </div>

                <Card className="mx-auto max-w-4xl py-0">
                    <CardHeader className="border-b py-8">
                        <CardDescription>{formatDate(post.published_at) ?? 'Aktuell'}</CardDescription>
                        <CardTitle className="text-3xl md:text-4xl">{post.title}</CardTitle>
                        {post.summary ? <div className="max-w-3xl text-base leading-7 text-zinc-700 dark:text-zinc-300">{post.summary}</div> : null}
                    </CardHeader>
                    <CardContent className="space-y-6 py-8">
                        <div className="max-w-3xl text-base leading-8 whitespace-pre-line text-zinc-700 dark:text-zinc-300">
                            {post.summary || 'Zu diesem Beitrag liegt noch kein ausfuehrlicher Text vor.'}
                        </div>

                        {post.external_href ? (
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
                                    <ArrowUpRight className="size-4" />
                                </a>
                            </Button>
                        ) : null}
                    </CardContent>
                </Card>
            </DefaultContainer>
        </>
    );
}

NewsShow.layout = (page: ReactNode) => <AppLayout children={page} />;

export default NewsShow;
