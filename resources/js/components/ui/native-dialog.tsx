import { X } from 'lucide-react';
import { PropsWithChildren, ReactNode, useEffect, useId, useRef } from 'react';

type NativeDialogProps = PropsWithChildren<{
    open: boolean;
    title: string;
    onClose: () => void;
    footer?: ReactNode;
}>;

export function NativeDialog({ open, title, onClose, footer, children }: NativeDialogProps) {
    const dialogRef = useRef<HTMLDialogElement | null>(null);
    const titleId = useId();

    useEffect(() => {
        const dialog = dialogRef.current;

        if (dialog === null) {
            return;
        }

        if (open && !dialog.open) {
            dialog.showModal();
        }

        if (!open && dialog.open) {
            dialog.close();
        }
    }, [open]);

    useEffect(() => {
        const dialog = dialogRef.current;

        if (dialog === null) {
            return;
        }

        const handleCancel = (event: Event) => {
            event.preventDefault();
            onClose();
        };

        const handleClose = () => {
            onClose();
        };

        dialog.addEventListener('cancel', handleCancel);
        dialog.addEventListener('close', handleClose);

        return () => {
            dialog.removeEventListener('cancel', handleCancel);
            dialog.removeEventListener('close', handleClose);
        };
    }, [onClose]);

    return (
        <dialog
            ref={dialogRef}
            aria-labelledby={titleId}
            className="w-full max-w-2xl rounded-3xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-2xl backdrop:bg-zinc-950/45 backdrop:backdrop-blur-sm dark:border-white/10 dark:bg-zinc-900 dark:text-white"
            onClick={(event) => {
                if (event.target === dialogRef.current) {
                    onClose();
                }
            }}
        >
            <div className="flex items-center justify-between border-b border-zinc-200 px-6 py-4 dark:border-white/10">
                <h2
                    id={titleId}
                    className="text-lg font-semibold"
                >
                    {title}
                </h2>
                <button
                    type="button"
                    aria-label="Dialog schliessen"
                    className="rounded-full p-2 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-white/10 dark:hover:text-white"
                    onClick={onClose}
                >
                    <X
                        aria-hidden="true"
                        className="size-4"
                    />
                </button>
            </div>

            <div className="px-6 py-5">{children}</div>

            {footer ? <div className="border-t border-zinc-200 px-6 py-4 dark:border-white/10">{footer}</div> : null}
        </dialog>
    );
}
