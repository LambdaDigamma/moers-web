import { DefaultContainer } from '@/components/default-container';
import { ReactNode } from 'react';

const DetailHeader = ({ content, navigation, actions }: { content?: ReactNode; navigation?: ReactNode; actions?: ReactNode }) => {
    return (
        <div className="border-b border-gray-200 dark:border-white/10">
            <div className="bg-white dark:bg-zinc-900">
                <DefaultContainer>
                    <div className="flex flex-row items-center space-x-4 pt-5 pb-3">
                        {content}
                        <div
                            className="grow-1"
                            aria-hidden={true}
                        ></div>
                        <div className="inline-flex items-center">{actions}</div>
                    </div>
                    <div className="-mx-2">{navigation}</div>
                </DefaultContainer>
            </div>
        </div>
    );
};

export { DetailHeader };
