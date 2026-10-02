import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { IsolatedSearchField } from '@/components/isolated-search-field';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import { Button } from '@/components/ui/button';
import { Card, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import AppLayout from '@/layouts/app-layout';
import { Link, router } from '@inertiajs/react';
import { ArrowUpRight, Plus, Search, UserRound } from 'lucide-react';
import { ReactNode, useEffect, useState } from 'react';
import { useDebounce } from 'use-debounce';
import Organisation = Modules.Management.Data.Organisation;

interface Props {
    organisations: Paginator<Organisation>;
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
    }, [debouncedSearch, filters.search]);

    return (
        <>
            <SeoHead
                title="Organisationen in Moers"
                description="Entdecke Vereine, Initiativen und Organisationen in Moers und finde passende Ansprechpartner und Angebote."
            />

            <div className="bg-background min-h-screen">
                <PageHeader
                    badge="Community-Netzwerk"
                    title="Partner & Organisationen"
                    description="Entdecken Sie die Vielfalt der Moerser Vereins- und Organisationslandschaft. Vom Sportverein bis zur Kulturinitiative – hier finden Sie alle Akteure auf einen Blick."
                    actions={
                        canCreate && (
                            <Button
                                asChild
                                size="lg"
                                className="rounded-lg px-6"
                            >
                                <Link href={route('organisations.create')}>
                                    <Plus className="mr-2 size-5" />
                                    Organisation hinzufügen
                                </Link>
                            </Button>
                        )
                    }
                >
                    <IsolatedSearchField
                        containerClassName="max-w-md"
                        aria-label="Organisationen suchen"
                        placeholder="Nach Namen oder Beschreibung suchen..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                    />
                </PageHeader>

                <DefaultContainer className="py-12">
                    {organisations.data.length > 0 ? (
                        <div className="grid gap-6 md:grid-cols-2">
                            {organisations.data.map((org) => (
                                <Link
                                    key={org.id}
                                    href={route('organisations.show', [org.slug])}
                                    className="group focus-visible:outline-ring rounded-xl focus-visible:outline-2 focus-visible:outline-offset-4"
                                >
                                    <Card className="group-hover:bg-muted h-full gap-5 shadow-none transition-colors">
                                        <CardHeader className="flex-row items-start justify-between gap-6">
                                            <div className="flex min-w-0 flex-1 flex-col gap-2">
                                                <CardTitle>
                                                    <h2 className="font-display tracking-title line-clamp-2 text-xl leading-snug group-hover:underline">
                                                        {org.name}
                                                    </h2>
                                                </CardTitle>
                                                <CardDescription className="line-clamp-3 leading-6">
                                                    {org.description || 'Diese Organisation hat noch keine Beschreibung hinterlegt.'}
                                                </CardDescription>
                                            </div>
                                            <div className="border-border bg-muted flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-lg border sm:size-20">
                                                {org.logoPath ? (
                                                    <img
                                                        src={org.logoPath}
                                                        alt=""
                                                        loading="lazy"
                                                        className="size-full object-cover"
                                                    />
                                                ) : (
                                                    <UserRound className="text-muted-foreground size-8" />
                                                )}
                                            </div>
                                        </CardHeader>
                                        <CardFooter className="mt-auto gap-1 text-sm font-semibold">
                                            Profil entdecken
                                            <ArrowUpRight className="size-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                                        </CardFooter>
                                    </Card>
                                </Link>
                            ))}
                        </div>
                    ) : (
                        <Empty>
                            <EmptyHeader>
                                <EmptyMedia variant="icon">
                                    <Search />
                                </EmptyMedia>
                                <EmptyTitle>Keine Organisationen gefunden</EmptyTitle>
                                <EmptyDescription>
                                    {search ? `Ihre Suche nach "${search}" ergab keine Treffer.` : 'Es wurden noch keine Organisationen angelegt.'}
                                </EmptyDescription>
                            </EmptyHeader>
                            {search && (
                                <EmptyContent>
                                    <Button
                                        variant="outline"
                                        onClick={() => setSearch('')}
                                    >
                                        Suche zurücksetzen
                                    </Button>
                                </EmptyContent>
                            )}
                        </Empty>
                    )}

                    <div className="pt-12">
                        <DefaultPagination paginator={organisations} />
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
};

OrganisationsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default OrganisationsIndex;
