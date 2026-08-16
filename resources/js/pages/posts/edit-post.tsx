import { DefaultContainer } from '@/components/default-container';
import { RichTextEditor } from '@/components/rich-text-editor';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Empty, EmptyDescription, EmptyHeader, EmptyTitle } from '@/components/ui/empty';
import { Description, ErrorMessage, Field, FieldGroup, Fieldset, Legend } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router, useForm } from '@inertiajs/react';
import type { JSONContent } from '@tiptap/react';
import { Archive, ImagePlus, LoaderCircle, Radio, RotateCcw, Save, Send, Trash2, Undo2 } from 'lucide-react';
import { ChangeEvent, FormEvent, ReactNode, useMemo, useState } from 'react';

type AvailableFeed = {
    id: number;
    name: string;
    identifier: string | null;
};

type EditablePost = {
    id: number;
    title: string | null;
    summary: string | null;
    slug: string | null;
    external_href: string | null;
    page_id: number | null;
    published_at: string | null;
    archived_at: string | null;
    deleted_at: string | null;
    is_imported: boolean;
    selected_feed_ids: number[];
    media_collections: {
        header?: App.Data.MediaData[];
    };
};

type PostFormData = {
    _method?: 'put';
    title: string;
    summary: string;
    slug: string;
    external_href: string;
    feed_ids: number[];
    content: JSONContent;
    header_image: File | null;
    remove_header_image: boolean;
};

type EditPostProps = {
    post: EditablePost | null;
    availableFeeds: AvailableFeed[];
    initialContent: JSONContent;
};

function statusBadges(post: EditablePost | null) {
    if (!post) {
        return [<Badge key="new">Neu</Badge>];
    }

    return [
        post.published_at ? (
            <Badge key="published">Veröffentlicht</Badge>
        ) : (
            <Badge
                key="draft"
                variant="outline"
            >
                Entwurf
            </Badge>
        ),
        post.archived_at ? (
            <Badge
                key="archived"
                variant="secondary"
            >
                Archiviert
            </Badge>
        ) : null,
        post.external_href ? (
            <Badge
                key="external"
                variant="outline"
            >
                Extern
            </Badge>
        ) : null,
        post.is_imported ? (
            <Badge
                key="imported"
                variant="secondary"
            >
                Importiert
            </Badge>
        ) : null,
    ].filter(Boolean);
}

const fieldError = (errors: Partial<Record<keyof PostFormData | string, string>>, field: string) =>
    errors[field as keyof PostFormData] ?? Object.entries(errors).find(([key]) => key.startsWith(`${field}.`))?.[1];

function EditPost({ post, availableFeeds, initialContent }: EditPostProps) {
    const [headerPreviewUrl, setHeaderPreviewUrl] = useState<string | null>(
        post?.media_collections.header?.[0]?.preview_url ?? post?.media_collections.header?.[0]?.full_url ?? null,
    );
    const [headerFileName, setHeaderFileName] = useState<string | null>(post?.media_collections.header?.[0]?.file_name ?? null);
    const form = useForm<PostFormData>({
        title: post?.title ?? '',
        summary: post?.summary ?? '',
        slug: post?.slug ?? '',
        external_href: post?.external_href ?? '',
        feed_ids: post?.selected_feed_ids ?? [],
        content: initialContent,
        header_image: null,
        remove_header_image: false,
    });

    const selectedFeedIds = useMemo(() => new Set(form.data.feed_ids), [form.data.feed_ids]);
    const contentError = fieldError(form.errors, 'content');
    const headerError = fieldError(form.errors, 'header_image');

    const submit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (!post) {
            form.post(route('posts.store'), { forceFormData: true });
            return;
        }

        form.transform((data) => ({ ...data, _method: 'put' }));
        form.post(route('posts.update', post.id), {
            forceFormData: true,
            onFinish: () => form.transform((data) => data),
        });
    };

    const updateFeedSelection = (feedId: number, checked: boolean) => {
        form.setData('feed_ids', checked ? [...form.data.feed_ids, feedId] : form.data.feed_ids.filter((id) => id !== feedId));
    };

    const handleHeaderSelection = (event: ChangeEvent<HTMLInputElement>) => {
        const file = event.target.files?.[0] ?? null;

        if (!file) {
            return;
        }

        if (headerPreviewUrl?.startsWith('blob:')) {
            URL.revokeObjectURL(headerPreviewUrl);
        }

        setHeaderPreviewUrl(URL.createObjectURL(file));
        setHeaderFileName(file.name);
        form.setData((data) => ({
            ...data,
            header_image: file,
            remove_header_image: false,
        }));
        event.target.value = '';
    };

    const removeHeader = () => {
        if (headerPreviewUrl?.startsWith('blob:')) {
            URL.revokeObjectURL(headerPreviewUrl);
        }

        setHeaderPreviewUrl(null);
        setHeaderFileName(null);
        form.setData((data) => ({
            ...data,
            header_image: null,
            remove_header_image: true,
        }));
    };

    const publish = () => {
        if (post) {
            router.post(route('posts.publish', post.id));
        }
    };

    const unpublish = () => {
        if (post) {
            router.post(route('posts.unpublish', post.id));
        }
    };

    const archive = () => {
        if (post) {
            router.post(route('posts.archive', post.id));
        }
    };

    const unarchive = () => {
        if (post) {
            router.post(route('posts.unarchive', post.id));
        }
    };

    return (
        <>
            <Head title={post ? 'Post bearbeiten' : 'Post erstellen'} />
            <DefaultContainer className="flex flex-col gap-6 py-8">
                <div className="flex flex-wrap items-start justify-between gap-4">
                    <div className="flex min-w-0 flex-col gap-2">
                        <div className="text-muted-foreground flex flex-wrap items-center gap-2 text-sm">
                            <Link
                                href={route('posts.index')}
                                className="hover:text-foreground"
                            >
                                Posts
                            </Link>
                            <span>/</span>
                            <Link
                                href={route('feeds.index')}
                                className="hover:text-foreground"
                            >
                                Feeds
                            </Link>
                        </div>
                        <div className="flex flex-col gap-2">
                            <h1 className="text-foreground text-2xl font-semibold tracking-tight md:text-3xl">
                                {post ? (post.title ?? 'Post bearbeiten') : 'Post erstellen'}
                            </h1>
                            <div className="flex flex-wrap gap-2">{statusBadges(post)}</div>
                        </div>
                    </div>

                    <div className="flex flex-wrap gap-2">
                        <Button
                            asChild
                            variant="outline"
                        >
                            <Link href={route('feeds.index')}>Feeds</Link>
                        </Button>
                        <Button
                            type="submit"
                            form="post-editor-form"
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
                    id="post-editor-form"
                    className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]"
                    onSubmit={submit}
                >
                    <div className="flex min-w-0 flex-col gap-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Beitrag</CardTitle>
                                <CardDescription>Titel und Zusammenfassung für Listen, APIs und öffentliche News-Ansichten.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <FieldGroup>
                                    <div className="grid gap-5">
                                        <Field data-invalid={Boolean(form.errors.title) || undefined}>
                                            <Label htmlFor="post-title">Titel</Label>
                                            <Input
                                                id="post-title"
                                                name="title"
                                                value={form.data.title}
                                                onChange={(event) => form.setData('title', event.target.value)}
                                                invalid={Boolean(form.errors.title)}
                                                aria-invalid={Boolean(form.errors.title)}
                                            />
                                            {form.errors.title ? <ErrorMessage>{form.errors.title}</ErrorMessage> : null}
                                        </Field>

                                        <Field data-invalid={Boolean(form.errors.summary) || undefined}>
                                            <Label htmlFor="post-summary">Zusammenfassung</Label>
                                            <Textarea
                                                id="post-summary"
                                                name="summary"
                                                className="min-h-28 resize-y"
                                                value={form.data.summary}
                                                onChange={(event) => form.setData('summary', event.target.value)}
                                                aria-invalid={Boolean(form.errors.summary)}
                                            />
                                            {form.errors.summary ? <ErrorMessage>{form.errors.summary}</ErrorMessage> : null}
                                        </Field>
                                    </div>
                                </FieldGroup>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Inhalt</CardTitle>
                                <CardDescription>Der Text wird als Page-Block gespeichert und über die Pages API ausgeliefert.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <RichTextEditor
                                    value={form.data.content}
                                    onChange={(content) => form.setData('content', content)}
                                    invalid={Boolean(contentError)}
                                />
                                {contentError ? <ErrorMessage className="mt-3">{contentError}</ErrorMessage> : null}
                            </CardContent>
                        </Card>
                    </div>

                    <aside className="flex flex-col gap-4 lg:sticky lg:top-6 lg:self-start">
                        {post?.is_imported ? (
                            <Alert>
                                <Radio className="size-4" />
                                <AlertTitle>RSS-Import</AlertTitle>
                                <AlertDescription>Importierte Felder können beim nächsten Import überschrieben werden.</AlertDescription>
                            </Alert>
                        ) : null}

                        <Card>
                            <CardHeader>
                                <CardTitle>Status</CardTitle>
                                <CardDescription>Veröffentlichen und Archivieren speichern keine offenen Formularänderungen.</CardDescription>
                            </CardHeader>
                            <CardContent className="flex flex-col gap-3">
                                {post ? (
                                    <>
                                        <div className="flex flex-wrap gap-2">{statusBadges(post)}</div>
                                        <Separator />
                                        <div className="grid gap-2">
                                            {post.published_at ? (
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    onClick={unpublish}
                                                >
                                                    <Undo2 data-icon="inline-start" />
                                                    Zurückziehen
                                                </Button>
                                            ) : (
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    onClick={publish}
                                                >
                                                    <Send data-icon="inline-start" />
                                                    Veröffentlichen
                                                </Button>
                                            )}
                                            {post.archived_at ? (
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    onClick={unarchive}
                                                >
                                                    <RotateCcw data-icon="inline-start" />
                                                    Wieder aktivieren
                                                </Button>
                                            ) : (
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    onClick={archive}
                                                >
                                                    <Archive data-icon="inline-start" />
                                                    Archivieren
                                                </Button>
                                            )}
                                        </div>
                                    </>
                                ) : (
                                    <p className="text-muted-foreground text-sm">Neue Beiträge werden zunächst als Entwurf gespeichert.</p>
                                )}
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Headerbild</CardTitle>
                            </CardHeader>
                            <CardContent className="flex flex-col gap-3">
                                {headerPreviewUrl ? (
                                    <div className="border-border overflow-hidden rounded-md border">
                                        <img
                                            src={headerPreviewUrl}
                                            alt={headerFileName ?? 'Headerbild'}
                                            className="aspect-[16/9] w-full object-cover"
                                        />
                                    </div>
                                ) : (
                                    <div className="bg-muted/40 text-muted-foreground flex aspect-[16/9] items-center justify-center rounded-md border border-dashed px-4 text-center text-sm">
                                        Kein Headerbild
                                    </div>
                                )}

                                <input
                                    id="post-header-image"
                                    name="header_image"
                                    type="file"
                                    accept="image/*"
                                    className="sr-only"
                                    onChange={handleHeaderSelection}
                                />
                                <div className="flex flex-wrap gap-2">
                                    <Button
                                        asChild
                                        variant="outline"
                                        size="sm"
                                    >
                                        <label
                                            htmlFor="post-header-image"
                                            className="cursor-pointer"
                                        >
                                            <ImagePlus data-icon="inline-start" />
                                            Bild wählen
                                        </label>
                                    </Button>
                                    {headerPreviewUrl ? (
                                        <Button
                                            type="button"
                                            variant="outline"
                                            size="sm"
                                            onClick={removeHeader}
                                        >
                                            <Trash2 data-icon="inline-start" />
                                            Entfernen
                                        </Button>
                                    ) : null}
                                </div>
                                {headerError ? <ErrorMessage>{headerError}</ErrorMessage> : null}
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Feeds</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <Fieldset>
                                    <Legend className="sr-only">Feed-Zuordnung</Legend>
                                    <Description>Wähle die Sammlungen, in denen dieser Beitrag erscheinen soll.</Description>
                                    {availableFeeds.length === 0 ? (
                                        <Empty className="bg-muted/20 mt-4 border py-8">
                                            <EmptyHeader>
                                                <EmptyTitle>Keine Feeds</EmptyTitle>
                                                <EmptyDescription>Es gibt noch keine Feeds.</EmptyDescription>
                                            </EmptyHeader>
                                        </Empty>
                                    ) : (
                                        <div className="mt-4 grid gap-2">
                                            {availableFeeds.map((feed) => {
                                                const feedControlId = `post-feed-${feed.id}`;

                                                return (
                                                    <label
                                                        key={feed.id}
                                                        htmlFor={feedControlId}
                                                        className="border-border bg-background hover:bg-muted/50 flex cursor-pointer items-start gap-3 rounded-md border p-3 text-sm transition-colors"
                                                    >
                                                        <Checkbox
                                                            id={feedControlId}
                                                            name="feed_ids[]"
                                                            checked={selectedFeedIds.has(feed.id)}
                                                            onCheckedChange={(checked) => updateFeedSelection(feed.id, checked === true)}
                                                        />
                                                        <span className="min-w-0">
                                                            <span className="text-foreground block truncate font-medium">{feed.name}</span>
                                                            {feed.identifier ? (
                                                                <span className="text-muted-foreground block truncate text-xs">
                                                                    {feed.identifier}
                                                                </span>
                                                            ) : null}
                                                        </span>
                                                    </label>
                                                );
                                            })}
                                        </div>
                                    )}
                                    {form.errors.feed_ids ? <ErrorMessage className="mt-3">{form.errors.feed_ids}</ErrorMessage> : null}
                                </Fieldset>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Details</CardTitle>
                                <CardDescription>Slug und externe Weiterleitung.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <FieldGroup>
                                    <div className="grid gap-4">
                                        <Field data-invalid={Boolean(form.errors.slug) || undefined}>
                                            <Label htmlFor="post-slug">Post-Slug</Label>
                                            <Input
                                                id="post-slug"
                                                name="slug"
                                                value={form.data.slug}
                                                onChange={(event) => form.setData('slug', event.target.value)}
                                                invalid={Boolean(form.errors.slug)}
                                                aria-invalid={Boolean(form.errors.slug)}
                                            />
                                            {form.errors.slug ? <ErrorMessage>{form.errors.slug}</ErrorMessage> : null}
                                        </Field>

                                        <Field data-invalid={Boolean(form.errors.external_href) || undefined}>
                                            <Label htmlFor="post-external-url">Externe URL</Label>
                                            <Input
                                                id="post-external-url"
                                                name="external_href"
                                                type="url"
                                                value={form.data.external_href}
                                                onChange={(event) => form.setData('external_href', event.target.value)}
                                                invalid={Boolean(form.errors.external_href)}
                                                aria-invalid={Boolean(form.errors.external_href)}
                                            />
                                            {form.errors.external_href ? <ErrorMessage>{form.errors.external_href}</ErrorMessage> : null}
                                        </Field>

                                        {post?.page_id ? <p className="text-muted-foreground text-xs">Page-ID: {post.page_id}</p> : null}
                                    </div>
                                </FieldGroup>
                            </CardContent>
                        </Card>
                    </aside>
                </form>
            </DefaultContainer>
        </>
    );
}

EditPost.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default EditPost;
