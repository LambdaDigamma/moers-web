import { Pagination, PaginationContent, PaginationItem, PaginationLink, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import React from 'react';

export const DefaultPagination: React.FC<{ paginator: Paginator<object> }> = ({ paginator }) => {
    return (
        <Pagination>
            <PaginationContent>
                <PaginationItem>
                    <PaginationPrevious href={paginator.meta?.prev_page_url ?? '#'} />
                </PaginationItem>
                {paginator.links?.slice(1, -1).map(({ url, label, active }) => {
                    return (
                        <PaginationItem key={label}>
                            <PaginationLink
                                href={url ?? '#'}
                                isActive={active}
                                dangerouslySetInnerHTML={{ __html: label }}
                            ></PaginationLink>
                        </PaginationItem>
                    );
                })}
                <PaginationItem>
                    <PaginationNext href={paginator.meta?.next_page_url ?? '#'} />
                </PaginationItem>
            </PaginationContent>
        </Pagination>
    );
};
