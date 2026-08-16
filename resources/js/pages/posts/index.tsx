import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Empty, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { FilePlus2, ListTree, Newspaper, Pencil } from 'lucide-react';
import { ReactNode } from 'react';

type PostListItem = {
    id: number;
    title: string | null;
    summary: string | null;
    published_at: string | null;
    archived_at: string | null;
    external_href: string | null;
    source_name: string | null;
    header_image_url: string | null;
};

function formatDateTime(value: string | null) {
    if (!value) {
        return 'Nicht veröffentlicht';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat('de-DE', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(date);
}

function PostStatus({ post }: { post: PostListItem }) {
    return (
        <div className="flex flex-wrap gap-1.5">
            <Badge variant={post.published_at ? 'default' : 'outline'}>{post.published_at ? 'Veröffentlicht' : 'Entwurf'}</Badge>
            {post.archived_at ? <Badge variant="secondary">Archiviert</Badge> : null}
            {post.external_href ? <Badge variant="outline">Extern</Badge> : null}
        </div>
    );
}

function PostsIndex({ posts }: { posts: Paginator<PostListItem> }) {
    return (
        <>
            <Head title="Beiträge" />
            <DefaultContainer className="flex flex-col gap-6 py-8">
                <div className="flex flex-wrap items-center justify-between gap-3">
                    <div className="flex flex-col gap-3">
                        <h1 className="text-foreground text-2xl font-semibold">Beiträge</h1>
                        <nav
                            aria-label="News-Verwaltung"
                            className="bg-muted/30 flex w-fit items-center gap-1 rounded-md border p-1"
                        >
                            <Button
                                asChild
                                size="sm"
                                variant="secondary"
                            >
                                <Link
                                    href={route('posts.index')}
                                    aria-current="page"
                                >
                                    <Newspaper data-icon="inline-start" />
                                    Beiträge
                                </Link>
                            </Button>
                            <Button
                                asChild
                                size="sm"
                                variant="ghost"
                            >
                                <Link href={route('feeds.index')}>
                                    <ListTree data-icon="inline-start" />
                                    Feeds
                                </Link>
                            </Button>
                        </nav>
                    </div>
                    <Button asChild>
                        <Link href={route('posts.create')}>
                            <FilePlus2 data-icon="inline-start" />
                            Beitrag erstellen
                        </Link>
                    </Button>
                </div>

                {posts.data.length === 0 ? (
                    <Empty className="border">
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <Newspaper />
                            </EmptyMedia>
                            <EmptyTitle>Noch keine Beiträge</EmptyTitle>
                            <EmptyDescription>Es sind noch keine Beiträge vorhanden.</EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                ) : (
                    <div className="bg-background overflow-hidden rounded-lg border shadow-xs">
                        <Table className="min-w-[760px]">
                            <TableHeader className="bg-muted/40">
                                <TableRow className="hover:bg-transparent">
                                    <TableHead className="h-9 w-[72px] px-3">Bild</TableHead>
                                    <TableHead className="h-9 px-3">Beitrag</TableHead>
                                    <TableHead className="h-9 w-[180px] px-3">Status</TableHead>
                                    <TableHead className="h-9 w-[160px] px-3">Quelle</TableHead>
                                    <TableHead className="h-9 w-[180px] px-3">Veröffentlicht</TableHead>
                                    <TableHead className="h-9 w-[120px] px-3 text-right">Aktion</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {posts.data.map((post) => (
                                    <TableRow key={post.id}>
                                        <TableCell className="px-3 py-2">
                                            <div className="bg-muted flex size-12 items-center justify-center overflow-hidden rounded-md">
                                                {post.header_image_url ? (
                                                    <img
                                                        src={post.header_image_url}
                                                        alt={post.title ?? 'Post'}
                                                        className="h-full w-full object-cover"
                                                    />
                                                ) : (
                                                    <Newspaper className="text-muted-foreground size-4" />
                                                )}
                                            </div>
                                        </TableCell>
                                        <TableCell className="max-w-[360px] px-3 py-2">
                                            <div className="flex min-w-0 flex-col gap-1">
                                                <div className="text-foreground truncate font-medium">{post.title ?? 'Ohne Titel'}</div>
                                                <div className="text-muted-foreground line-clamp-1 text-sm">
                                                    {post.summary ?? 'Keine Zusammenfassung hinterlegt.'}
                                                </div>
                                            </div>
                                        </TableCell>
                                        <TableCell className="px-3 py-2">
                                            <PostStatus post={post} />
                                        </TableCell>
                                        <TableCell className="text-muted-foreground px-3 py-2 text-sm">{post.source_name ?? 'Direkt'}</TableCell>
                                        <TableCell className="text-muted-foreground px-3 py-2 text-sm">{formatDateTime(post.published_at)}</TableCell>
                                        <TableCell className="px-3 py-2 text-right">
                                            <Button
                                                asChild
                                                size="sm"
                                                variant="outline"
                                            >
                                                <Link href={route('posts.edit', post.id)}>
                                                    <Pencil data-icon="inline-start" />
                                                    Bearbeiten
                                                </Link>
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                )}

                <DefaultPagination paginator={posts} />
            </DefaultContainer>
        </>
    );
}

PostsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default PostsIndex;
