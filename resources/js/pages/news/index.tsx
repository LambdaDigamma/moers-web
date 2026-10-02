import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { NewsPreview } from '@/components/news-preview';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import { Button } from '@/components/ui/button';
import { Empty, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import AppLayout from '@/layouts/app-layout';
import { type HomeNewsPost } from '@/types/home';
import { Link } from '@inertiajs/react';
import { ListTree, Newspaper, Pencil } from 'lucide-react';
import { ReactNode } from 'react';

function NewsIndex({ posts, canManageNews = false }: { posts: Paginator<HomeNewsPost>; canManageNews?: boolean }) {
    const [leadPost, ...remainingPosts] = posts.data;
    const topPosts = remainingPosts.slice(0, 3);
    const morePosts = remainingPosts.slice(3);
    return (
        <>
            <SeoHead
                title="Aktuelle News aus Moers"
                description="Aktuelle Nachrichten und Meldungen aus Moers, gesammelt aus regionalen Quellen und übersichtlich mit Vorschau dargestellt."
            />
            <PageHeader
                badge="Nachrichten"
                title="Aktuelles aus Moers"
                description="Nachrichten aus der Stadt und der Region. Alle Meldungen mit Quelle, Datum und einem direkten Link zum Beitrag."
                actions={
                    canManageNews && (
                        <>
                            <Button
                                asChild
                                variant="outline"
                            >
                                <Link href={route('posts.index')}>
                                    <Pencil data-icon="inline-start" />
                                    Posts verwalten
                                </Link>
                            </Button>
                            <Button
                                asChild
                                variant="outline"
                            >
                                <Link href={route('feeds.index')}>
                                    <ListTree data-icon="inline-start" />
                                    Feeds verwalten
                                </Link>
                            </Button>
                        </>
                    )
                }
            />
            <DefaultContainer className="flex flex-col gap-12 py-12 md:py-16">
                {!leadPost ? (
                    <Empty>
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <Newspaper />
                            </EmptyMedia>
                            <EmptyTitle>Keine Nachrichten verfügbar</EmptyTitle>
                            <EmptyDescription>Aktuell sind keine Beiträge veröffentlicht.</EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                ) : (
                    <>
                        <section
                            aria-label="Aktuelle Nachrichten"
                            className="grid items-start gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.8fr)]"
                        >
                            <NewsPreview
                                post={leadPost}
                                variant="lead"
                            />
                            <ul className="divide-border flex flex-col divide-y">
                                {topPosts.map((post) => (
                                    <li
                                        key={post.id}
                                        className="py-6 first:pt-0 last:pb-0"
                                    >
                                        <NewsPreview
                                            post={post}
                                            variant="row"
                                        />
                                    </li>
                                ))}
                            </ul>
                        </section>
                        {morePosts.length > 0 && (
                            <section
                                aria-label="Weitere Nachrichten"
                                className="border-border grid gap-x-8 gap-y-12 border-t pt-12 sm:grid-cols-2 lg:grid-cols-3"
                            >
                                {morePosts.map((post) => (
                                    <NewsPreview
                                        key={post.id}
                                        post={post}
                                    />
                                ))}
                            </section>
                        )}
                        <DefaultPagination paginator={posts} />
                    </>
                )}
            </DefaultContainer>
        </>
    );
}

NewsIndex.layout = (page: ReactNode) => <AppLayout children={page} />;
export default NewsIndex;
