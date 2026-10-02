import { DefaultContainer } from '@/components/default-container';
import { NewsPreview } from '@/components/news-preview';
import { SectionHeader } from '@/components/section-header';
import { type HomeNewsPost } from '@/types/home';

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
                        <NewsPreview
                            headingLevel={3}
                            post={leadPost}
                            variant="lead"
                        />
                        <ul className="divide-border flex flex-col divide-y">
                            {morePosts.map((post) => (
                                <li
                                    key={post.id}
                                    className="py-6 first:pt-0 last:pb-0"
                                >
                                    <NewsPreview
                                        headingLevel={3}
                                        post={post}
                                        variant="row"
                                    />
                                </li>
                            ))}
                        </ul>
                    </div>
                )}
            </DefaultContainer>
        </section>
    );
}
