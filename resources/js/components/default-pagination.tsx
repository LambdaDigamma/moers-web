import { Button } from '@/components/ui/button';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationLink,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { ChevronLeft, ChevronRight } from 'lucide-react';

type PaginationData = {
    links: Paginator<unknown>['links'];
    meta?: Pick<Paginator<unknown>['meta'], 'prev_page_url' | 'next_page_url'>;
};

export function DefaultPagination({ paginator }: { paginator: PaginationData }) {
    if (paginator.links.length <= 3) {
        return null;
    }
    const previousUrl = paginator.meta?.prev_page_url ?? paginator.links[0]?.url;
    const nextUrl = paginator.meta?.next_page_url ?? paginator.links.at(-1)?.url;
    return (
        <Pagination
            aria-label="Seitennavigation"
            className="justify-center"
        >
            <PaginationContent className="flex-wrap justify-center">
                <PaginationItem>
                    {previousUrl ? (
                        <PaginationPrevious
                            href={previousUrl}
                            preserveScroll
                        />
                    ) : (
                        <Button
                            variant="ghost"
                            size="icon"
                            disabled
                            aria-label="Vorherige Seite"
                        >
                            <ChevronLeft />
                        </Button>
                    )}
                </PaginationItem>
                {paginator.links.slice(1, -1).map(({ url, label, active }, index) => (
                    <PaginationItem key={`${label}-${index}`}>
                        {url ? (
                            <PaginationLink
                                href={url}
                                isActive={active}
                                aria-label={`Seite ${label}`}
                                preserveScroll
                                dangerouslySetInnerHTML={{ __html: label }}
                            />
                        ) : (
                            <PaginationEllipsis />
                        )}
                    </PaginationItem>
                ))}
                <PaginationItem>
                    {nextUrl ? (
                        <PaginationNext
                            href={nextUrl}
                            preserveScroll
                        />
                    ) : (
                        <Button
                            variant="ghost"
                            size="icon"
                            disabled
                            aria-label="Nächste Seite"
                        >
                            <ChevronRight />
                        </Button>
                    )}
                </PaginationItem>
            </PaginationContent>
        </Pagination>
    );
}
