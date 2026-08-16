import { Button } from '@/components/ui/button';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import { cn } from '@/lib/utils';
import { EditorContent, type JSONContent, useEditor } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';
import { Bold, Heading2, Italic, List, ListOrdered, type LucideIcon, Pilcrow, Redo2, Undo2 } from 'lucide-react';

type RichTextEditorProps = {
    value: JSONContent;
    onChange: (value: JSONContent) => void;
    invalid?: boolean;
};

export function RichTextEditor({ value, onChange, invalid = false }: RichTextEditorProps) {
    const editor = useEditor({
        extensions: [StarterKit],
        content: value,
        immediatelyRender: false,
        editorProps: {
            attributes: {
                class: 'min-h-72 px-4 py-3 text-sm leading-6 text-foreground outline-none',
            },
        },
        onUpdate: ({ editor: activeEditor }) => {
            onChange(activeEditor.getJSON());
        },
    });

    const run = (command: () => boolean) => {
        command();
        editor?.commands.focus();
    };

    const toolbarButtonClass = (isActive = false) =>
        cn(
            'text-muted-foreground size-8 border border-transparent',
            'hover:text-accent-foreground',
            isActive && 'border-input bg-accent text-accent-foreground shadow-xs',
        );

    const toolbarButton = ({
        label,
        icon: Icon,
        isActive,
        onClick,
        disabled = false,
        pressed,
    }: {
        label: string;
        icon: LucideIcon;
        isActive?: boolean;
        onClick: () => void;
        disabled?: boolean;
        pressed?: boolean;
    }) => (
        <Tooltip>
            <TooltipTrigger asChild>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    className={toolbarButtonClass(isActive)}
                    onClick={onClick}
                    disabled={disabled}
                    aria-label={label}
                    aria-pressed={pressed}
                >
                    <Icon />
                    <span className="sr-only">{label}</span>
                </Button>
            </TooltipTrigger>
            <TooltipContent side="bottom">{label}</TooltipContent>
        </Tooltip>
    );

    return (
        <div
            className={cn('bg-background overflow-hidden rounded-lg border shadow-xs', invalid ? 'border-destructive' : 'border-input')}
            aria-invalid={invalid}
        >
            <div className="border-border bg-muted/40 flex flex-wrap items-center gap-1 border-b p-1.5">
                {toolbarButton({
                    label: 'Absatz',
                    icon: Pilcrow,
                    isActive: editor?.isActive('paragraph'),
                    pressed: editor?.isActive('paragraph') ?? false,
                    onClick: () => run(() => editor?.chain().focus().setParagraph().run() ?? false),
                    disabled: !editor,
                })}
                {toolbarButton({
                    label: 'Überschrift 2',
                    icon: Heading2,
                    isActive: editor?.isActive('heading', { level: 2 }),
                    pressed: editor?.isActive('heading', { level: 2 }) ?? false,
                    onClick: () => run(() => editor?.chain().focus().toggleHeading({ level: 2 }).run() ?? false),
                    disabled: !editor,
                })}
                <div
                    className="bg-border mx-1 h-6 w-px"
                    aria-hidden="true"
                />
                {toolbarButton({
                    label: 'Fett',
                    icon: Bold,
                    isActive: editor?.isActive('bold'),
                    pressed: editor?.isActive('bold') ?? false,
                    onClick: () => run(() => editor?.chain().focus().toggleBold().run() ?? false),
                    disabled: !editor,
                })}
                {toolbarButton({
                    label: 'Kursiv',
                    icon: Italic,
                    isActive: editor?.isActive('italic'),
                    pressed: editor?.isActive('italic') ?? false,
                    onClick: () => run(() => editor?.chain().focus().toggleItalic().run() ?? false),
                    disabled: !editor,
                })}
                <div
                    className="bg-border mx-1 h-6 w-px"
                    aria-hidden="true"
                />
                {toolbarButton({
                    label: 'Aufzählung',
                    icon: List,
                    isActive: editor?.isActive('bulletList'),
                    pressed: editor?.isActive('bulletList') ?? false,
                    onClick: () => run(() => editor?.chain().focus().toggleBulletList().run() ?? false),
                    disabled: !editor,
                })}
                {toolbarButton({
                    label: 'Nummerierte Liste',
                    icon: ListOrdered,
                    isActive: editor?.isActive('orderedList'),
                    pressed: editor?.isActive('orderedList') ?? false,
                    onClick: () => run(() => editor?.chain().focus().toggleOrderedList().run() ?? false),
                    disabled: !editor,
                })}
                <div className="ml-auto flex gap-1">
                    {toolbarButton({
                        label: 'Rückgängig',
                        icon: Undo2,
                        onClick: () => run(() => editor?.chain().focus().undo().run() ?? false),
                        disabled: !editor || !editor.can().undo(),
                    })}
                    {toolbarButton({
                        label: 'Wiederholen',
                        icon: Redo2,
                        onClick: () => run(() => editor?.chain().focus().redo().run() ?? false),
                        disabled: !editor || !editor.can().redo(),
                    })}
                </div>
            </div>
            <EditorContent
                editor={editor}
                className="max-w-none [&_.ProseMirror_h2]:mt-6 [&_.ProseMirror_h2]:text-xl [&_.ProseMirror_h2]:font-semibold [&_.ProseMirror_li]:ml-5 [&_.ProseMirror_ol]:list-decimal [&_.ProseMirror_p]:my-3 [&_.ProseMirror_strong]:font-semibold [&_.ProseMirror_ul]:list-disc"
            />
        </div>
    );
}
