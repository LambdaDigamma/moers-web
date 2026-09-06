import { Link } from '@inertiajs/react';

const linkClassName =
    'rounded-sm text-zinc-600 underline-offset-4 transition-colors hover:text-zinc-950 hover:underline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent-600 dark:text-zinc-400 dark:hover:text-white';

export function AppFooter() {
    return (
        <footer className="border-t border-zinc-200 bg-white dark:border-white/10 dark:bg-zinc-950">
            <div className="mx-auto flex w-full max-w-7xl flex-col gap-3 px-4 py-6 text-sm sm:flex-row sm:items-center sm:justify-between">
                <p className="text-zinc-500 dark:text-zinc-500">&copy; {new Date().getFullYear()} Inventas GmbH</p>

                <nav
                    aria-label="Rechtliche Hinweise"
                    className="flex flex-wrap gap-x-5 gap-y-2"
                >
                    <Link
                        href={route('legal.privacy')}
                        className={linkClassName}
                    >
                        Datenschutz
                    </Link>
                    <Link
                        href={route('legal.tac')}
                        className={linkClassName}
                    >
                        Nutzungsbedingungen
                    </Link>
                    <a
                        href="https://inventas.io/impressum"
                        target="_blank"
                        rel="noopener noreferrer"
                        className={linkClassName}
                    >
                        Impressum
                        <span className="sr-only"> (öffnet in einem neuen Tab)</span>
                    </a>
                </nav>
            </div>
        </footer>
    );
}
