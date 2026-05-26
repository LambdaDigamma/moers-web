import { Button } from '@/components/ui/button';
import { ErrorMessage, Field } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NativeDialog } from '@/components/ui/native-dialog';
import { ArrowLeft, ArrowRight, ImagePlus, Pencil, Star, Trash2 } from 'lucide-react';
import { ChangeEvent, useEffect, useMemo, useRef, useState } from 'react';

export type EditableMediaItem = {
    clientId: string;
    id?: number;
    file?: File | null;
    previewUrl: string;
    fileName: string;
    alt: string;
    caption: string;
    credits: string;
};

export function editableMediaItemFromServer(media: App.Data.MediaData): EditableMediaItem {
    return {
        clientId: `existing-${media.id}`,
        id: media.id,
        file: null,
        previewUrl: media.preview_url ?? media.full_url,
        fileName: media.file_name,
        alt: media.alt ?? '',
        caption: media.caption ?? '',
        credits: media.credits ?? '',
    };
}

function editableMediaItemFromFile(file: File): EditableMediaItem {
    return {
        clientId: `new-${crypto.randomUUID()}`,
        file,
        previewUrl: URL.createObjectURL(file),
        fileName: file.name,
        alt: '',
        caption: '',
        credits: '',
    };
}

function revokePreviewUrl(item: EditableMediaItem): void {
    if (item.file && item.previewUrl.startsWith('blob:')) {
        URL.revokeObjectURL(item.previewUrl);
    }
}

type LocationMediaEditorProps = {
    items: EditableMediaItem[];
    onChange: (items: EditableMediaItem[]) => void;
    error?: string;
};

export function LocationMediaEditor({ items, onChange, error }: LocationMediaEditorProps) {
    const [editingMediaClientId, setEditingMediaClientId] = useState<string | null>(null);
    const itemsRef = useRef(items);

    useEffect(() => {
        itemsRef.current = items;
    }, [items]);

    useEffect(() => {
        return () => {
            itemsRef.current.forEach(revokePreviewUrl);
        };
    }, []);

    const editingMedia = useMemo(() => items.find((item) => item.clientId === editingMediaClientId) ?? null, [editingMediaClientId, items]);

    const updateItem = (clientId: string, updates: Partial<EditableMediaItem>) => {
        onChange(items.map((item) => (item.clientId === clientId ? { ...item, ...updates } : item)));
    };

    const moveItem = (clientId: string, direction: -1 | 1) => {
        const currentIndex = items.findIndex((item) => item.clientId === clientId);
        const targetIndex = currentIndex + direction;

        if (currentIndex < 0 || targetIndex < 0 || targetIndex >= items.length) {
            return;
        }

        const nextItems = [...items];
        const [item] = nextItems.splice(currentIndex, 1);
        nextItems.splice(targetIndex, 0, item);
        onChange(nextItems);
    };

    const removeItem = (clientId: string) => {
        const item = items.find((entry) => entry.clientId === clientId);

        if (item) {
            revokePreviewUrl(item);
        }

        onChange(items.filter((entry) => entry.clientId !== clientId));

        if (editingMediaClientId === clientId) {
            setEditingMediaClientId(null);
        }
    };

    const handleFileSelection = (event: ChangeEvent<HTMLInputElement>) => {
        const files = Array.from(event.target.files ?? []);

        if (files.length === 0) {
            return;
        }

        onChange([...items, ...files.map((file) => editableMediaItemFromFile(file))]);
        event.target.value = '';
    };

    return (
        <div className="space-y-4">
            <div className="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 className="text-lg font-semibold text-zinc-950 dark:text-white">Header-Bilder</h2>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400">Das erste Bild dient in den Apps als Hero-Bild fuer den Ort.</p>
                </div>

                <label className="inline-flex cursor-pointer items-center">
                    <input
                        type="file"
                        accept="image/*"
                        multiple
                        className="peer sr-only"
                        onChange={handleFileSelection}
                    />
                    <span className="bg-primary text-primary-foreground hover:bg-primary/90 peer-focus-visible:border-ring peer-focus-visible:ring-ring/50 inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium shadow-xs transition peer-focus-visible:ring-[3px] peer-focus-visible:outline-none">
                        <ImagePlus className="size-4" />
                        Bilder hinzufuegen
                    </span>
                </label>
            </div>

            {items.length === 0 ? (
                <div className="rounded-3xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-10 text-center text-sm text-zinc-500 dark:border-white/10 dark:bg-white/5 dark:text-zinc-400">
                    Noch keine Header-Bilder hinterlegt.
                </div>
            ) : (
                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    {items.map((item, index) => (
                        <article
                            key={item.clientId}
                            className="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-white/10 dark:bg-zinc-900"
                        >
                            <div className="relative aspect-[4/3] overflow-hidden bg-zinc-100 dark:bg-white/5">
                                <img
                                    src={item.previewUrl}
                                    alt={item.alt || item.fileName}
                                    className="h-full w-full object-cover"
                                />
                                {index === 0 ? (
                                    <div className="absolute top-3 left-3 inline-flex items-center gap-2 rounded-full bg-zinc-950/80 px-3 py-1 text-xs font-medium text-white">
                                        <Star className="size-3.5 fill-current" />
                                        Hero
                                    </div>
                                ) : null}
                            </div>

                            <div className="space-y-3 px-4 py-4">
                                <div className="min-w-0">
                                    <p className="truncate text-sm font-medium text-zinc-950 dark:text-white">{item.fileName}</p>
                                    <p className="text-xs text-zinc-500 dark:text-zinc-400">
                                        {item.alt || item.caption || item.credits ? 'Metadaten vorhanden' : 'Keine Metadaten'}
                                    </p>
                                </div>

                                <div className="flex flex-wrap gap-2">
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        disabled={index === 0}
                                        onClick={() => moveItem(item.clientId, -1)}
                                    >
                                        <ArrowLeft className="size-4" />
                                        Nach vorne
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        disabled={index === items.length - 1}
                                        onClick={() => moveItem(item.clientId, 1)}
                                    >
                                        <ArrowRight className="size-4" />
                                        Nach hinten
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        onClick={() => setEditingMediaClientId(item.clientId)}
                                    >
                                        <Pencil className="size-4" />
                                        Attribute
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="destructive"
                                        size="sm"
                                        onClick={() => removeItem(item.clientId)}
                                    >
                                        <Trash2 className="size-4" />
                                        Entfernen
                                    </Button>
                                </div>
                            </div>
                        </article>
                    ))}
                </div>
            )}

            {error ? <ErrorMessage>{error}</ErrorMessage> : null}

            <NativeDialog
                open={editingMedia !== null}
                title="Bildattribute bearbeiten"
                onClose={() => setEditingMediaClientId(null)}
                footer={
                    <div className="flex justify-end">
                        <Button
                            type="button"
                            onClick={() => setEditingMediaClientId(null)}
                        >
                            Fertig
                        </Button>
                    </div>
                }
            >
                {editingMedia ? (
                    <div className="grid gap-6 md:grid-cols-[minmax(0,220px)_1fr]">
                        <div className="overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100 dark:border-white/10 dark:bg-white/5">
                            <img
                                src={editingMedia.previewUrl}
                                alt={editingMedia.alt || editingMedia.fileName}
                                className="aspect-[4/3] h-full w-full object-cover"
                            />
                        </div>

                        <div className="space-y-4">
                            <Field>
                                <Label htmlFor="media-alt">Alternativtext</Label>
                                <Input
                                    id="media-alt"
                                    value={editingMedia.alt}
                                    onChange={(event) => updateItem(editingMedia.clientId, { alt: event.target.value })}
                                />
                            </Field>

                            <Field>
                                <Label htmlFor="media-caption">Bildunterschrift</Label>
                                <Input
                                    id="media-caption"
                                    value={editingMedia.caption}
                                    onChange={(event) => updateItem(editingMedia.clientId, { caption: event.target.value })}
                                />
                            </Field>

                            <Field>
                                <Label htmlFor="media-credits">Credits</Label>
                                <Input
                                    id="media-credits"
                                    value={editingMedia.credits}
                                    onChange={(event) => updateItem(editingMedia.clientId, { credits: event.target.value })}
                                />
                            </Field>
                        </div>
                    </div>
                ) : null}
            </NativeDialog>
        </div>
    );
}
