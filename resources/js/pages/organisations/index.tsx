import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Heading } from '@/components/ui/heading';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router } from '@inertiajs/react';
import { ArrowUpRight, Plus, Search, UserRound } from 'lucide-react';
import { ReactNode, useEffect, useState } from 'react';
import { useDebounce } from 'use-debounce';
import Organisation = Modules.Management.Data.Organisation;

interface Props {
    organisations: {
        data: Organisation[];
        links: any[];
        meta: any;
    };
    filters: {
        search: string;
    };
    canCreate: boolean;
}

const OrganisationsIndex = ({ organisations, filters, canCreate }: Props) => {
    const [search, setSearch] = useState(filters.search || '');
    const [debouncedSearch] = useDebounce(search, 300);

    useEffect(() => {
        if (debouncedSearch !== filters.search) {
            router.get(route('organisations.index'), { search: debouncedSearch }, { preserveState: true, replace: true });
        }
    }, [debouncedSearch]);

    return (
        <>
            <Head title="Organisationen" />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <header className="relative overflow-hidden border-b border-zinc-200 bg-white py-16 dark:border-white/5 dark:bg-zinc-900/50">
                    <div className="absolute inset-0 bg-linear-to-br from-emerald-500/5 via-transparent to-sky-500/5" />
                    <DefaultContainer className="relative">
                        <div className="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                            <div className="max-w-2xl space-y-6">
                                <div className="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50/50 px-3 py-1 text-xs font-medium tracking-wide text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    <div className="size-1.5 animate-pulse rounded-full bg-emerald-500" />
                                    Community-Netzwerk
                                </div>
                                <div className="space-y-4">
                                    <Heading className="text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl lg:text-6xl dark:text-white">
                                        Partner & Organisationen
                                    </Heading>
                                    <p className="text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                                        Entdecken Sie die Vielfalt der Moerser Vereins- und Organisationslandschaft. Vom Sportverein bis zur
                                        Kulturinitiative – hier finden Sie alle Akteure auf einen Blick.
                                    </p>
                                </div>
                            </div>
                            {canCreate && (
                                <div className="flex shrink-0 gap-3">
                                    <Button
                                        asChild
                                        size="lg"
                                        className="rounded-2xl bg-zinc-950 px-8 text-white shadow-xl shadow-emerald-500/10 hover:bg-zinc-800 dark:bg-emerald-600 dark:hover:bg-emerald-700"
                                    >
                                        <Link href={route('organisations.create')}>
                                            <Plus className="mr-2 size-5" />
                                            Organisation hinzufügen
                                        </Link>
                                    </Button>
                                </div>
                            )}
                        </div>
                    </DefaultContainer>
                </header>

                <DefaultContainer className="py-12">
                    <div className="mb-12">
                        <div className="relative max-w-md">
                            <Search className="absolute top-1/2 left-4 size-5 -translate-y-1/2 text-zinc-400" />
                            <Input
                                placeholder="Nach Namen oder Beschreibung suchen..."
                                className="h-12 rounded-2xl border-zinc-200 bg-white pl-12 shadow-sm ring-offset-emerald-500 focus-visible:ring-emerald-500 dark:border-white/10 dark:bg-zinc-900"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                        </div>
                    </div>

                    {organisations.data.length > 0 ? (
                        <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            {organisations.data.map((org) => (
                                <Card
                                    key={org.id}
                                    className="group relative overflow-hidden rounded-[2.5rem] border-zinc-200 bg-white p-2 transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-zinc-200/50 dark:border-white/5 dark:bg-zinc-900 dark:hover:shadow-none"
                                >
                                    <div className="relative aspect-video overflow-hidden rounded-[2rem] bg-zinc-100 dark:bg-white/5">
                                        {org.logoPath ? (
                                            <img
                                                src={org.logoPath}
                                                alt={org.name}
                                                className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            />
                                        ) : (
                                            <div className="flex h-full w-full items-center justify-center">
                                                <UserRound className="size-16 text-zinc-300 dark:text-zinc-700" />
                                            </div>
                                        )}
                                        <div className="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity group-hover:opacity-100" />
                                    </div>

                                    <CardHeader className="px-6 pt-6 pb-2">
                                        <CardTitle className="line-clamp-1 text-2xl font-bold text-zinc-950 dark:text-white">{org.name}</CardTitle>
                                    </CardHeader>
                                    <CardContent className="px-6 pt-0 pb-8">
                                        <p className="line-clamp-2 min-h-[3rem] text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                                            {org.description || 'Diese Organisation hat noch keine Beschreibung hinterlegt.'}
                                        </p>
                                        <Button
                                            asChild
                                            variant="link"
                                            className="group/link mt-4 h-auto p-0 font-bold text-emerald-600 dark:text-emerald-400"
                                        >
                                            <Link href={route('organisations.show', [org.slug])}>
                                                Profil entdecken
                                                <ArrowUpRight className="ml-1 size-4 transition-transform group-hover/link:translate-x-0.5 group-hover/link:-translate-y-0.5" />
                                            </Link>
                                        </Button>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    ) : (
                        <div className="flex flex-col items-center justify-center py-24 text-center">
                            <div className="flex size-16 items-center justify-center rounded-full bg-zinc-100 dark:bg-white/5">
                                <Search className="size-8 text-zinc-400" />
                            </div>
                            <h3 className="mt-4 text-lg font-semibold text-zinc-950 dark:text-white">Keine Organisationen gefunden</h3>
                            <p className="mt-2 text-zinc-600 dark:text-zinc-400">
                                {search ? `Ihre Suche nach "${search}" ergab keine Treffer.` : 'Es wurden noch keine Organisationen angelegt.'}
                            </p>
                            {search && (
                                <Button
                                    variant="link"
                                    onClick={() => setSearch('')}
                                    className="mt-4 text-emerald-600"
                                >
                                    Suche zurücksetzen
                                </Button>
                            )}
                        </div>
                    )}

                    {/* Simple Pagination Placeholder */}
                    {organisations.meta.last_page > 1 && organisations.links && (
                        <div className="mt-12 flex justify-center gap-2">
                            {organisations.links.map((link: any, i: number) => (
                                <Button
                                    key={i}
                                    variant={link.active ? 'default' : 'outline'}
                                    disabled={!link.url}
                                    asChild={!!link.url}
                                    className="rounded-lg"
                                >
                                    {link.url ? (
                                        <Link
                                            href={link.url}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ) : (
                                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                    )}
                                </Button>
                            ))}
                        </div>
                    )}
                </DefaultContainer>
            </div>
        </>
    );
};

OrganisationsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default OrganisationsIndex;
