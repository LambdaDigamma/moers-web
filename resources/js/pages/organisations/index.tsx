import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input, InputGroup } from '@/components/ui/input';
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
                <PageHeader
                    badge="Community-Netzwerk"
                    title="Partner & Organisationen"
                    description="Entdecken Sie die Vielfalt der Moerser Vereins- und Organisationslandschaft. Vom Sportverein bis zur Kulturinitiative – hier finden Sie alle Akteure auf einen Blick."
                    actions={
                        canCreate && (
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
                        )
                    }
                >
                    <InputGroup className="max-w-md">
                        <Search
                            data-slot="icon"
                            className="size-5"
                        />
                        <Input
                            placeholder="Nach Namen oder Beschreibung suchen..."
                            className="h-12 rounded-2xl border-zinc-200 bg-white shadow-lg ring-offset-emerald-500 focus-visible:ring-emerald-500 dark:border-white/10 dark:bg-zinc-900"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                        />
                    </InputGroup>
                </PageHeader>

                <DefaultContainer className="py-12">
                    {organisations.data.length > 0 ? (
                        <div className="grid gap-6 md:grid-cols-2">
                            {organisations.data.map((org) => (
                                <Link
                                    key={org.id}
                                    href={route('organisations.show', [org.slug])}
                                    className="group"
                                >
                                    <Card className="h-full border-zinc-200 bg-white p-6 transition-all hover:-translate-y-1 hover:shadow-xl dark:border-white/5 dark:bg-zinc-900">
                                        <div className="flex items-start justify-between gap-6">
                                            <div className="flex-1 space-y-2">
                                                <h3 className="line-clamp-1 text-xl font-bold text-zinc-950 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                                    {org.name}
                                                </h3>
                                                <p className="line-clamp-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                                                    {org.description || 'Diese Organisation hat noch keine Beschreibung hinterlegt.'}
                                                </p>
                                                <div className="flex items-center pt-2 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                    Profil entdecken
                                                    <ArrowUpRight className="ml-1 size-3 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                                                </div>
                                            </div>

                                            <div className="flex size-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-zinc-100 bg-zinc-50 dark:border-white/5 dark:bg-white/5">
                                                {org.logoPath ? (
                                                    <img
                                                        src={org.logoPath}
                                                        alt={org.name}
                                                        className="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                                                    />
                                                ) : (
                                                    <UserRound className="size-10 text-zinc-300 dark:text-zinc-700" />
                                                )}
                                            </div>
                                        </div>
                                    </Card>
                                </Link>
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
