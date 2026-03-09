import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button';
import { Heading } from '@/components/ui/heading';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { ReactNode } from 'react';

type EditablePost = {
    id: number;
    title: string | null;
    summary: string | null;
};

const EditPost = ({ post }: { post: EditablePost | null }) => {
    const form = useForm({
        title: post?.title ?? '',
        summary: post?.summary ?? '',
    });

    const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (post) {
            form.put(`/posts/${post.id}`);
            return;
        }

        form.post('/posts');
    };

    return (
        <>
            <Head title={post ? 'Post bearbeiten' : 'Post erstellen'} />
            <DefaultContainer className="space-y-6 py-8">
                <div className="flex items-center justify-between">
                    <Heading>{post ? 'Post bearbeiten' : 'Post erstellen'}</Heading>
                    <Button
                        asChild
                        variant="outline"
                    >
                        <Link href="/posts">Zur Liste</Link>
                    </Button>
                </div>

                <form
                    className="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow dark:border-white/10 dark:bg-gray-900"
                    onSubmit={handleSubmit}
                >
                    <div className="space-y-2">
                        <Label htmlFor="title">Titel</Label>
                        <Input
                            id="title"
                            value={form.data.title}
                            onChange={(event) => form.setData('title', event.target.value)}
                        />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="summary">Zusammenfassung</Label>
                        <textarea
                            id="summary"
                            className="border-input min-h-32 w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs outline-none"
                            value={form.data.summary}
                            onChange={(event) => form.setData('summary', event.target.value)}
                        />
                    </div>

                    <Button
                        type="submit"
                        disabled={form.processing}
                    >
                        Speichern
                    </Button>
                </form>
            </DefaultContainer>
        </>
    );
};

EditPost.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default EditPost;
