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

type FeedListItem = {
    id: number;
    name: string | null;
    identifier: string | null;
    posts_count: number;
    deleted_at: string | null;
};

function formatPostCount(count: number) {
    return new Intl.NumberFormat('de-DE').format(count);
}

function FeedsIndex({ feeds }: { feeds: Paginator<FeedListItem> }) {
    return (
        <>
            <Head title="Feeds" />
            <DefaultContainer className="flex flex-col gap-6 py-8">
                <div className="flex flex-wrap items-center justify-between gap-3">
                    <div className="flex flex-col gap-3">
                        <h1 className="text-foreground text-2xl font-semibold">Feeds</h1>
                        <nav
                            aria-label="News-Verwaltung"
                            className="bg-muted/30 flex w-fit items-center gap-1 rounded-md border p-1"
                        >
                            <Button
                                asChild
                                size="sm"
                                variant="ghost"
                            >
                                <Link href={route('posts.index')}>
                                    <Newspaper data-icon="inline-start" />
                                    Beiträge
                                </Link>
                            </Button>
                            <Button
                                asChild
                                size="sm"
                                variant="secondary"
                            >
                                <Link
                                    href={route('feeds.index')}
                                    aria-current="page"
                                >
                                    <ListTree data-icon="inline-start" />
                                    Feeds
                                </Link>
                            </Button>
                        </nav>
                    </div>
                    <Button asChild>
                        <Link href={route('feeds.create')}>
                            <FilePlus2 data-icon="inline-start" />
                            Feed erstellen
                        </Link>
                    </Button>
                </div>

                {feeds.data.length === 0 ? (
                    <Empty className="border">
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <ListTree />
                            </EmptyMedia>
                            <EmptyTitle>Noch keine Feeds</EmptyTitle>
                            <EmptyDescription>Es sind noch keine Feeds vorhanden.</EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                ) : (
                    <div className="bg-background overflow-hidden rounded-lg border shadow-xs">
                        <Table className="min-w-[640px]">
                            <TableHeader className="bg-muted/40">
                                <TableRow className="hover:bg-transparent">
                                    <TableHead className="h-9 px-3">Feed</TableHead>
                                    <TableHead className="h-9 px-3">Kennung</TableHead>
                                    <TableHead className="h-9 w-[120px] px-3">Status</TableHead>
                                    <TableHead className="h-9 w-[120px] px-3 text-right">Beiträge</TableHead>
                                    <TableHead className="h-9 w-[120px] px-3 text-right">Aktion</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {feeds.data.map((feed) => (
                                    <TableRow key={feed.id}>
                                        <TableCell className="max-w-[280px] px-3 py-2">
                                            <div className="text-foreground truncate font-medium">{feed.name ?? 'Ohne Name'}</div>
                                        </TableCell>
                                        <TableCell className="text-muted-foreground max-w-[320px] px-3 py-2 text-sm">
                                            <div className="truncate">{feed.identifier ?? 'Keine Kennung'}</div>
                                        </TableCell>
                                        <TableCell className="px-3 py-2">
                                            {feed.deleted_at ? <Badge variant="secondary">Gelöscht</Badge> : <Badge>Aktiv</Badge>}
                                        </TableCell>
                                        <TableCell className="text-muted-foreground px-3 py-2 text-right text-sm">
                                            {formatPostCount(feed.posts_count)}
                                        </TableCell>
                                        <TableCell className="px-3 py-2 text-right">
                                            <Button
                                                asChild
                                                size="sm"
                                                variant="outline"
                                            >
                                                <Link href={route('feeds.edit', feed.id)}>
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

                <DefaultPagination paginator={feeds} />
            </DefaultContainer>
        </>
    );
}

FeedsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default FeedsIndex;
