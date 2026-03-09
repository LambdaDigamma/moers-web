import { DefaultContainer } from '@/components/default-container';
import { Badge } from '@/components/ui/badge';
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
}

const OrganisationsIndex = ({ organisations, filters }: Props) => {
    const [search, setSearch] = useState(filters.search || '');
    const [debouncedSearch] = useDebounce(search, 300);

    useEffect(() => {
        if (debouncedSearch !== filters.search) {
            router.get(
                route('organisations.index'),
                { search: debouncedSearch },
                { preserveState: true, replace: true }
            );
        }
    }, [debouncedSearch]);

    return (
        <>
            <Head title="Organisationen" />

            <div className="min-h-screen bg-white dark:bg-zinc-950">
                <header className="border-b border-zinc-200 bg-zinc-50 py-12 dark:border-white/5 dark:bg-zinc-900/50">
                    <DefaultContainer>
                        <div className="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                            <div className="space-y-4">
                                <Badge className="bg-emerald-600 text-white shadow-none">Management</Badge>
                                <Heading className="text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl dark:text-white">
                                    Organisationen
                                </Heading>
                                <p className="text-lg text-zinc-600 dark:text-zinc-400">
                                    Verwalten Sie alle beteiligten Organisationen und Veranstalter.
                                </p>
                            </div>
                            <div>
                                <Button asChild className="rounded-xl bg-zinc-950 text-white hover:bg-zinc-800 dark:bg-emerald-600 dark:hover:bg-emerald-700">
                                    <Link href={route('organisations.create')}>
                                        <Plus className="mr-2 size-4" />
                                        Neue Organisation
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </DefaultContainer>
                </header>

                <DefaultContainer className="py-12">
                    <div className="mb-12 flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div className="relative flex-1">
                            <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" />
                            <Input
                                placeholder="Organisationen suchen..."
                                className="pl-10 rounded-xl border-zinc-200 dark:border-white/10"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                        </div>
                    </div>

                    {organisations.data.length > 0 ? (
                        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            {organisations.data.map((org) => (
                                <Card key={org.id} className="group overflow-hidden rounded-3xl border-zinc-200 bg-white transition-all hover:shadow-md dark:border-white/5 dark:bg-zinc-900">
                                    <CardHeader className="p-6">
                                        <div className="flex items-center gap-4">
                                            {org.logoPath ? (
                                                <img
                                                    src={org.logoPath}
                                                    alt={org.name}
                                                    className="size-16 rounded-2xl border border-zinc-200 bg-white object-cover shadow-sm dark:border-white/10"
                                                />
                                            ) : (
                                                <div className="flex size-16 items-center justify-center rounded-2xl border border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-white/5">
                                                    <UserRound className="size-8 text-zinc-300 dark:text-zinc-700" />
                                                </div>
                                            )}
                                            <div className="min-w-0 flex-1">
                                                <CardTitle className="truncate text-xl font-bold text-zinc-950 dark:text-white">
                                                    {org.name}
                                                </CardTitle>
                                                <Link
                                                    href={route('organisations.show', [org.slug])}
                                                    className="mt-1 inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-500"
                                                >
                                                    Profil ansehen
                                                    <ArrowUpRight className="ml-1 size-3" />
                                                </Link>
                                            </div>
                                        </div>
                                    </CardHeader>
                                    <CardContent className="px-6 pb-6 pt-0">
                                        <p className="line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400">
                                            {org.description || 'Keine Beschreibung verfügbar.'}
                                        </p>
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
                                        <Link href={link.url} dangerouslySetInnerHTML={{ __html: link.label }} />
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
