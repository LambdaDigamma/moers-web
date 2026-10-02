import { DefaultContainer } from '@/components/default-container';
import { ReactNode } from 'react';

const DetailHeader = ({ content, navigation, actions }: { content?: ReactNode; navigation?: ReactNode; actions?: ReactNode }) => {
    return (
        <div className="border-border bg-background border-b">
            <div>
                <DefaultContainer>
                    <div className="flex flex-col justify-between gap-6 pt-10 pb-6 sm:flex-row sm:items-center">
                        <div className="min-w-0">{content}</div>
                        {actions && <div className="inline-flex shrink-0 flex-wrap items-center gap-3">{actions}</div>}
                    </div>
                    <div className="-mx-2 overflow-x-auto">{navigation}</div>
                </DefaultContainer>
            </div>
        </div>
    );
};

export { DetailHeader };
