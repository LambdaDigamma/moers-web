import AppLogoIcon from '@/components/app-logo-icon';
import { Card, CardContent, CardDescription, CardHeader } from '@/components/ui/card';
import { Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { type PropsWithChildren } from 'react';

export default function AuthCardLayout({ children, title, description }: PropsWithChildren<{ name?: string; title?: string; description?: string }>) {
    return (
        <>
            <Head>
                <meta
                    head-key="robots"
                    name="robots"
                    content="noindex, nofollow"
                />
            </Head>
            <div className="bg-muted flex min-h-svh flex-col">
                <header className="bg-hero text-hero-foreground border-hero-divider border-b">
                    <div className="max-w-page mx-auto flex h-[72px] items-center px-4 sm:px-6 lg:px-8">
                        <Link
                            href={route('home')}
                            className="focus-visible:outline-ring inline-flex items-center gap-3 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-4"
                        >
                            <AppLogoIcon className="size-9 fill-current" />
                            <span className="font-display tracking-title text-xl font-semibold">
                                Mein Moers<span className="text-accent-500">.</span>
                            </span>
                        </Link>
                    </div>
                </header>
                <main className="flex flex-1 items-center justify-center px-4 py-12 sm:px-6 md:py-16">
                    <div className="flex w-full max-w-md flex-col gap-6">
                        <Card className="gap-7 shadow-none">
                            <CardHeader className="gap-3 px-6 pt-2 sm:px-8">
                                <span className="text-eyebrow text-accent-700 dark:text-accent-400">Mein Konto</span>
                                <h1 className="font-display tracking-heading text-3xl leading-tight font-semibold">{title}</h1>
                                <CardDescription className="leading-6">{description}</CardDescription>
                            </CardHeader>
                            <CardContent className="px-6 pb-2 sm:px-8">{children}</CardContent>
                        </Card>
                        <Link
                            href={route('home')}
                            className="text-muted-foreground hover:text-foreground focus-visible:outline-ring inline-flex items-center gap-2 self-start rounded-sm text-sm focus-visible:outline-2 focus-visible:outline-offset-4"
                        >
                            <ArrowLeft className="size-4" />
                            Zurück zur Startseite
                        </Link>
                    </div>
                </main>
            </div>
        </>
    );
}
