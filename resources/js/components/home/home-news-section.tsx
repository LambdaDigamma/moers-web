import { DefaultContainer } from '@/components/default-container';
import { SectionHeader } from '@/components/section-header';
import { formatPublishedAt } from '@/lib/date-format';
import { cn } from '@/lib/utils';
import { type HomeNewsPost } from '@/types/home';
import { ImageIcon } from 'lucide-react';

const linkPropsOf = (post: HomeNewsPost) =>
    post.external_href ? { href: post.external_href, target: '_blank', rel: 'noreferrer' } : { href: route('news.show', [post.id]) };

function NewsMeta({ post }: { post: HomeNewsPost }) {
    return (
        <div className="flex items-center gap-2 text-[13px] leading-4">
            {post.source_name && <span className="text-foreground font-semibold">{post.source_name}</span>}
            {post.source_name && post.published_at && (
                <span
                    aria-hidden="true"
                    className="text-graphit-400"
                >
                    ·
                </span>
            )}
            {post.published_at && <span className="text-muted-foreground">{formatPublishedAt(post.published_at)}</span>}
        </div>
    );
}

function NewsImage({ post, className, showIcon = false }: { post: HomeNewsPost; className?: string; showIcon?: boolean }) {
    return (
        <div
            className={cn(
                'from-graphit-200 to-graphit-100 dark:from-graphit-800 dark:to-graphit-900 relative shrink-0 overflow-hidden bg-linear-135',
                className,
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
                showIcon && (
                    <div className="text-graphit-400 flex size-full items-center justify-center">
                        <ImageIcon
                            className="size-8"
                            strokeWidth={1.5}
                        />
                    </div>
                )
            )}
        </div>
    );
}

export function HomeNewsSection({ posts }: { posts: HomeNewsPost[] }) {
    const [leadPost, ...morePosts] = posts;

    return (
        <section className="border-border bg-muted border-y">
            <DefaultContainer className="flex flex-col gap-10 pt-20 pb-20 md:pt-[88px] md:pb-24">
                <SectionHeader
                    eyebrow="Nachrichten"
                    title="Aktuelles aus Moers"
                    action={{ label: 'Alle Nachrichten', href: route('news.index') }}
                />

                {!leadPost ? (
                    <p className="text-muted-foreground text-sm">Keine aktuellen Nachrichten gefunden.</p>
                ) : (
                    <div className="grid grid-cols-1 items-start gap-10 lg:grid-cols-[minmax(0,1fr)_520px]">
                        <a
                            {...linkPropsOf(leadPost)}
                            className="group flex flex-col gap-5"
                        >
                            <NewsImage
                                post={leadPost}
                                showIcon
                                className="aspect-video rounded-xl lg:aspect-auto lg:h-[400px]"
                            />
                            <div className="flex flex-col gap-2.5">
                                <NewsMeta post={leadPost} />
                                <h3 className="font-display tracking-heading text-2xl leading-tight font-semibold group-hover:underline md:text-3xl md:leading-9">
                                    {leadPost.title}
                                </h3>
                                {leadPost.summary && <p className="text-muted-foreground line-clamp-3 leading-[26px]">{leadPost.summary}</p>}
                            </div>
                        </a>

                        <ul className="divide-border flex flex-col divide-y">
                            {morePosts.map((post) => (
                                <li
                                    key={post.id}
                                    className="py-6 first:pt-0 last:pb-0"
                                >
                                    <a
                                        {...linkPropsOf(post)}
                                        className="group flex gap-5"
                                    >
                                        <NewsImage
                                            post={post}
                                            className="h-24 w-[132px] rounded-lg"
                                        />
                                        <div className="flex min-w-0 flex-col gap-2">
                                            <NewsMeta post={post} />
                                            <h3 className="line-clamp-2 text-[17px] leading-6 font-semibold group-hover:underline">{post.title}</h3>
                                        </div>
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>
                )}
            </DefaultContainer>
        </section>
    );
}
