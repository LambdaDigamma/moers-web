import { formatPublishedAt } from '@/lib/date-format';
import { cn } from '@/lib/utils';
import { type HomeNewsPost } from '@/types/home';
import { Link } from '@inertiajs/react';
import { ImageIcon } from 'lucide-react';

type NewsPreviewProps = {
    post: HomeNewsPost;
    variant?: 'lead' | 'row' | 'tile';
    headingLevel?: 2 | 3;
};

export function NewsPreview({ post, variant = 'tile', headingLevel = 2 }: NewsPreviewProps) {
    const Heading = headingLevel === 2 ? 'h2' : 'h3';
    const isRow = variant === 'row';
    const className = cn(
        'group focus-visible:outline-ring flex min-w-0 gap-5 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-4',
        isRow ? 'flex-row' : 'flex-col',
    );
    const content = (
        <>
            <div
                className={cn(
                    'bg-muted relative shrink-0 overflow-hidden rounded-lg',
                    isRow ? 'h-24 w-24 sm:w-[132px]' : 'aspect-video',
                    variant === 'lead' && 'rounded-xl lg:aspect-auto lg:h-[400px]',
                )}
            >
                {post.header_image_url ? (
                    <img
                        src={post.header_image_url}
                        alt=""
                        loading="lazy"
                        className="size-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                    />
                ) : (
                    <div className="text-muted-foreground flex size-full items-center justify-center">
                        <ImageIcon
                            className="size-8"
                            strokeWidth={1.5}
                        />
                    </div>
                )}
            </div>
            <div className="flex min-w-0 flex-col gap-2.5">
                <div className="text-muted-foreground flex flex-wrap items-center gap-x-2 gap-y-1 text-[13px] leading-4">
                    {post.source_name && <span className="text-foreground font-semibold">{post.source_name}</span>}
                    {post.source_name && post.published_at && <span aria-hidden="true">·</span>}
                    {post.published_at && <time dateTime={post.published_at}>{formatPublishedAt(post.published_at)}</time>}
                </div>
                <Heading
                    className={cn(
                        'font-display tracking-heading leading-snug font-semibold group-hover:underline',
                        isRow ? 'line-clamp-3 text-[17px]' : 'text-2xl',
                        variant === 'lead' && 'md:text-3xl md:leading-9',
                    )}
                >
                    {post.title}
                </Heading>
                {!isRow && post.summary && <p className="text-muted-foreground line-clamp-3 leading-[26px]">{post.summary}</p>}
            </div>
        </>
    );

    return post.external_href ? (
        <a
            href={post.external_href}
            target="_blank"
            rel="noreferrer"
            className={className}
        >
            {content}
        </a>
    ) : (
        <Link
            href={route('news.show', [post.id])}
            className={className}
        >
            {content}
        </Link>
    );
}
