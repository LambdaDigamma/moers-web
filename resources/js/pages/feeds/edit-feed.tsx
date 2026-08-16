import { DefaultContainer } from '@/components/default-container';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Empty, EmptyDescription, EmptyHeader, EmptyTitle } from '@/components/ui/empty';
import { ErrorMessage, Field, FieldGroup } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { ArrowDown, ArrowUp, ListPlus, LoaderCircle, RotateCcw, Save, Trash2, X } from 'lucide-react';
import { FormEvent, ReactNode, useMemo, useState } from 'react';

type FeedPost = {
    id: number;
    title: string;
    order: number;
    published_at: string | null;
    archived_at: string | null;
};

type AvailablePost = {
    id: number;
    title: string;
    published_at: string | null;
    archived_at: string | null;
};

type EditableFeed = {
    id: number;
    name: string | null;
    identifier: string | null;
    deleted_at: string | null;
    posts: FeedPost[];
};

type FeedFormData = {
    name: string;
    identifier: string;
    posts: FeedPost[];
};

type EditFeedProps = {
    feed: EditableFeed | null;
    availablePosts: AvailablePost[];
};

function PostBadges({ post }: { post: Pick<AvailablePost, 'published_at' | 'archived_at'> }) {
    return (
        <div className="flex flex-wrap gap-2">
            {post.published_at ? <Badge>Veröffentlicht</Badge> : <Badge variant="outline">Entwurf</Badge>}
            {post.archived_at ? <Badge variant="secondary">Archiviert</Badge> : null}
        </div>
    );
}

function normalizePosts(posts: FeedPost[]): FeedPost[] {
    return posts.map((post, index) => ({ ...post, order: index }));
}

function EditFeed({ feed, availablePosts }: EditFeedProps) {
    const [postToAdd, setPostToAdd] = useState<string>('');
    const form = useForm<FeedFormData>({
        name: feed?.name ?? '',
        identifier: feed?.identifier ?? '',
        posts: normalizePosts(feed?.posts ?? []),
    });

    const selectedPostIds = useMemo(() => new Set(form.data.posts.map((post) => post.id)), [form.data.posts]);
    const selectablePosts = availablePosts.filter((post) => !selectedPostIds.has(post.id));

    const submit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.transform((data) => ({ ...data, posts: normalizePosts(data.posts) }));

        if (!feed) {
            form.post(route('feeds.store'), {
                onFinish: () => form.transform((data) => data),
            });
            return;
        }

        form.put(route('feeds.update', feed.id), {
            onFinish: () => form.transform((data) => data),
        });
    };

    const addPost = () => {
        const post = availablePosts.find((entry) => entry.id === Number(postToAdd));

        if (!post) {
            return;
        }

        form.setData('posts', normalizePosts([...form.data.posts, { ...post, order: form.data.posts.length }]));
        setPostToAdd('');
    };

    const removePost = (postId: number) => {
        form.setData('posts', normalizePosts(form.data.posts.filter((post) => post.id !== postId)));
    };

    const movePost = (postId: number, direction: -1 | 1) => {
        const currentIndex = form.data.posts.findIndex((post) => post.id === postId);
        const targetIndex = currentIndex + direction;

        if (currentIndex < 0 || targetIndex < 0 || targetIndex >= form.data.posts.length) {
            return;
        }

        const nextPosts = [...form.data.posts];
        const [post] = nextPosts.splice(currentIndex, 1);
        nextPosts.splice(targetIndex, 0, post);
        form.setData('posts', normalizePosts(nextPosts));
    };

    const destroyFeed = () => {
        if (feed) {
            router.delete(route('feeds.destroy', feed.id));
        }
    };

    const restoreFeed = () => {
        if (feed) {
            router.post(route('feeds.restore', feed.id));
        }
    };

    return (
        <>
            <Head title={feed ? 'Feed bearbeiten' : 'Feed erstellen'} />
            <DefaultContainer className="flex flex-col gap-6 py-8">
                <div className="flex flex-wrap items-start justify-between gap-4">
                    <div className="flex min-w-0 flex-col gap-2">
                        <div className="text-muted-foreground flex flex-wrap items-center gap-2 text-sm">
                            <Link
                                href={route('feeds.index')}
                                className="hover:text-foreground"
                            >
                                Feeds
                            </Link>
                            <span>/</span>
                            <Link
                                href={route('posts.index')}
                                className="hover:text-foreground"
                            >
                                Posts
                            </Link>
                        </div>
                        <div className="flex flex-col gap-2">
                            <h1 className="text-foreground text-2xl font-semibold tracking-tight md:text-3xl">
                                {feed ? (feed.name ?? 'Feed bearbeiten') : 'Feed erstellen'}
                            </h1>
                            <div className="flex flex-wrap gap-2">
                                {feed?.deleted_at ? <Badge variant="secondary">Gelöscht</Badge> : <Badge>{feed ? 'Aktiv' : 'Neu'}</Badge>}
                            </div>
                        </div>
                    </div>

                    <div className="flex flex-wrap gap-2">
                        <Button
                            asChild
                            variant="outline"
                        >
                            <Link href={route('posts.index')}>Posts</Link>
                        </Button>
                        <Button
                            type="submit"
                            form="feed-editor-form"
                            disabled={form.processing}
                        >
                            {form.processing ? (
                                <LoaderCircle
                                    data-icon="inline-start"
                                    className="animate-spin"
                                />
                            ) : (
                                <Save data-icon="inline-start" />
                            )}
                            Speichern
                        </Button>
                    </div>
                </div>

                <form
                    id="feed-editor-form"
                    className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]"
                    onSubmit={submit}
                >
                    <div className="flex min-w-0 flex-col gap-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Feed</CardTitle>
                                <CardDescription>Name und operative Kennung für API, Import und Verwaltung.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <FieldGroup>
                                    <div className="grid gap-5 md:grid-cols-2">
                                        <Field data-invalid={Boolean(form.errors.name) || undefined}>
                                            <Label htmlFor="feed-name">Name</Label>
                                            <Input
                                                id="feed-name"
                                                name="name"
                                                value={form.data.name}
                                                onChange={(event) => form.setData('name', event.target.value)}
                                                invalid={Boolean(form.errors.name)}
                                                aria-invalid={Boolean(form.errors.name)}
                                            />
                                            {form.errors.name ? <ErrorMessage>{form.errors.name}</ErrorMessage> : null}
                                        </Field>

                                        <Field data-invalid={Boolean(form.errors.identifier) || undefined}>
                                            <Label htmlFor="feed-identifier">Kennung</Label>
                                            <Input
                                                id="feed-identifier"
                                                name="identifier"
                                                value={form.data.identifier}
                                                onChange={(event) => form.setData('identifier', event.target.value)}
                                                disabled={Boolean(feed)}
                                                invalid={Boolean(form.errors.identifier)}
                                                aria-invalid={Boolean(form.errors.identifier)}
                                            />
                                            {form.errors.identifier ? <ErrorMessage>{form.errors.identifier}</ErrorMessage> : null}
                                        </Field>
                                    </div>
                                </FieldGroup>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader className="gap-4 md:flex-row md:items-start md:justify-between">
                                <div className="flex flex-col gap-1.5">
                                    <CardTitle>Beiträge</CardTitle>
                                    <CardDescription>
                                        Manuelle Reihenfolge als zweite Sortierung nach der chronologischen Hauptsortierung.
                                    </CardDescription>
                                </div>
                                <div className="grid gap-2 md:min-w-80 md:grid-cols-[minmax(0,1fr)_auto]">
                                    <Select
                                        value={postToAdd}
                                        onValueChange={setPostToAdd}
                                        disabled={selectablePosts.length === 0}
                                    >
                                        <SelectTrigger aria-label="Beitrag auswählen">
                                            <SelectValue placeholder="Beitrag auswählen" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                {selectablePosts.map((post) => (
                                                    <SelectItem
                                                        key={post.id}
                                                        value={String(post.id)}
                                                    >
                                                        {post.title}
                                                    </SelectItem>
                                                ))}
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        onClick={addPost}
                                        disabled={!postToAdd}
                                    >
                                        <ListPlus data-icon="inline-start" />
                                        Hinzufügen
                                    </Button>
                                </div>
                            </CardHeader>
                            <CardContent>
                                {form.data.posts.length === 0 ? (
                                    <Empty className="bg-muted/20 border py-10">
                                        <EmptyHeader>
                                            <EmptyTitle>Keine Beiträge</EmptyTitle>
                                            <EmptyDescription>Dieser Feed enthält noch keine Beiträge.</EmptyDescription>
                                        </EmptyHeader>
                                    </Empty>
                                ) : (
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead className="w-16">Nr.</TableHead>
                                                <TableHead>Beitrag</TableHead>
                                                <TableHead>Status</TableHead>
                                                <TableHead className="w-32 text-right">Aktionen</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {form.data.posts.map((post, index) => (
                                                <TableRow key={post.id}>
                                                    <TableCell className="text-muted-foreground font-medium">{index + 1}</TableCell>
                                                    <TableCell className="min-w-64">
                                                        <span className="text-foreground block truncate font-medium">{post.title}</span>
                                                    </TableCell>
                                                    <TableCell>
                                                        <PostBadges post={post} />
                                                    </TableCell>
                                                    <TableCell>
                                                        <div className="flex justify-end gap-1">
                                                            <Tooltip>
                                                                <TooltipTrigger asChild>
                                                                    <Button
                                                                        type="button"
                                                                        variant="ghost"
                                                                        size="icon"
                                                                        disabled={index === 0}
                                                                        onClick={() => movePost(post.id, -1)}
                                                                    >
                                                                        <ArrowUp />
                                                                        <span className="sr-only">Nach oben</span>
                                                                    </Button>
                                                                </TooltipTrigger>
                                                                <TooltipContent>Nach oben</TooltipContent>
                                                            </Tooltip>
                                                            <Tooltip>
                                                                <TooltipTrigger asChild>
                                                                    <Button
                                                                        type="button"
                                                                        variant="ghost"
                                                                        size="icon"
                                                                        disabled={index === form.data.posts.length - 1}
                                                                        onClick={() => movePost(post.id, 1)}
                                                                    >
                                                                        <ArrowDown />
                                                                        <span className="sr-only">Nach unten</span>
                                                                    </Button>
                                                                </TooltipTrigger>
                                                                <TooltipContent>Nach unten</TooltipContent>
                                                            </Tooltip>
                                                            <Tooltip>
                                                                <TooltipTrigger asChild>
                                                                    <Button
                                                                        type="button"
                                                                        variant="ghost"
                                                                        size="icon"
                                                                        onClick={() => removePost(post.id)}
                                                                    >
                                                                        <X />
                                                                        <span className="sr-only">Entfernen</span>
                                                                    </Button>
                                                                </TooltipTrigger>
                                                                <TooltipContent>Entfernen</TooltipContent>
                                                            </Tooltip>
                                                        </div>
                                                    </TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                )}
                                {form.errors.posts ? <ErrorMessage className="mt-3">{form.errors.posts}</ErrorMessage> : null}
                            </CardContent>
                        </Card>
                    </div>

                    <aside className="flex flex-col gap-4 lg:sticky lg:top-6 lg:self-start">
                        <Card>
                            <CardHeader>
                                <CardTitle>Status</CardTitle>
                            </CardHeader>
                            <CardContent className="flex flex-col gap-3">
                                <div className="flex flex-wrap gap-2">
                                    {feed?.deleted_at ? <Badge variant="secondary">Gelöscht</Badge> : <Badge>{feed ? 'Aktiv' : 'Neu'}</Badge>}
                                </div>
                                {feed?.identifier ? <p className="text-muted-foreground text-sm">Kennung: {feed.identifier}</p> : null}
                            </CardContent>
                        </Card>

                        {feed ? (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Verwaltung</CardTitle>
                                    <CardDescription>Gelöschte Feeds behalten ihre Beitrag-Zuordnungen.</CardDescription>
                                </CardHeader>
                                <CardContent className="flex flex-col gap-3">
                                    {feed.deleted_at ? (
                                        <Button
                                            type="button"
                                            variant="outline"
                                            onClick={restoreFeed}
                                        >
                                            <RotateCcw data-icon="inline-start" />
                                            Wiederherstellen
                                        </Button>
                                    ) : (
                                        <AlertDialog>
                                            <AlertDialogTrigger asChild>
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                >
                                                    <Trash2 data-icon="inline-start" />
                                                    Löschen
                                                </Button>
                                            </AlertDialogTrigger>
                                            <AlertDialogContent>
                                                <AlertDialogHeader>
                                                    <AlertDialogTitle>Feed löschen?</AlertDialogTitle>
                                                    <AlertDialogDescription>
                                                        Der Feed wird soft-deleted. Bestehende Beitrag-Zuordnungen bleiben für eine spätere
                                                        Wiederherstellung erhalten.
                                                    </AlertDialogDescription>
                                                </AlertDialogHeader>
                                                <AlertDialogFooter>
                                                    <AlertDialogCancel type="button">Abbrechen</AlertDialogCancel>
                                                    <AlertDialogAction
                                                        type="button"
                                                        className="bg-destructive hover:bg-destructive/90 text-white"
                                                        onClick={destroyFeed}
                                                    >
                                                        Löschen
                                                    </AlertDialogAction>
                                                </AlertDialogFooter>
                                            </AlertDialogContent>
                                        </AlertDialog>
                                    )}
                                    <Separator />
                                    <p className="text-muted-foreground text-xs">
                                        Speichern ändert Name und Beitragsliste. Löschen oder Wiederherstellen ist eine eigene Aktion.
                                    </p>
                                </CardContent>
                            </Card>
                        ) : null}
                    </aside>
                </form>
            </DefaultContainer>
        </>
    );
}

EditFeed.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default EditFeed;
