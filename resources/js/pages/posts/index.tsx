import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { Button } from '@/components/ui/button';
import { Heading } from '@/components/ui/heading';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ReactNode } from 'react';

type PostListItem = {
    id: number;
    title: string | null;
    summary: string | null;
};

const PostsIndex = ({ posts }: { posts: Paginator<PostListItem> }) => {
    return (
        <>
            <Head title="Posts" />
            <DefaultContainer className="space-y-6 py-8">
                <div className="flex items-center justify-between">
                    <Heading>Posts</Heading>
                    <Button asChild>
                        <Link href="/posts/create">Post erstellen</Link>
                    </Button>
                </div>

                <ul className="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow dark:divide-white/10 dark:border-white/10 dark:bg-gray-900">
                    {posts.data.map((post) => (
                        <li
                            key={post.id}
                            className="flex items-center justify-between px-4 py-3"
                        >
                            <div>
                                <div className="font-medium">{post.title ?? 'Ohne Titel'}</div>
                                <div className="text-sm text-gray-500">{post.summary ?? 'Keine Zusammenfassung'}</div>
                            </div>
                            <Button
                                asChild
                                variant="outline"
                            >
                                <Link href={`/posts/${post.id}/edit`}>Bearbeiten</Link>
                            </Button>
                        </li>
                    ))}
                </ul>

                <DefaultPagination paginator={posts} />
            </DefaultContainer>
        </>
    );
};

PostsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default PostsIndex;
