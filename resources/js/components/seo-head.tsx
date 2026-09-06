import { appName, formatPageTitle } from '@/lib/seo';
import { Head } from '@inertiajs/react';

type SeoHeadProps = {
    title: string;
    description: string;
    canonicalUrl?: string | null;
    imageUrl?: string | null;
    type?: 'article' | 'website';
};

function normalizeDescription(description: string): string {
    const normalizedDescription = description.replace(/\s+/g, ' ').trim();

    return normalizedDescription.length > 160 ? `${normalizedDescription.slice(0, 157).trimEnd()}...` : normalizedDescription;
}

function getCurrentUrl(): string | null {
    if (typeof window === 'undefined') {
        return null;
    }

    return `${window.location.origin}${window.location.pathname}`;
}

export function SeoHead({ title, description, canonicalUrl, imageUrl, type = 'website' }: SeoHeadProps) {
    const fullTitle = formatPageTitle(title);
    const normalizedDescription = normalizeDescription(description);
    const currentUrl = canonicalUrl ?? getCurrentUrl();

    return (
        <Head title={title}>
            {currentUrl ? (
                <link
                    head-key="canonical"
                    rel="canonical"
                    href={currentUrl}
                />
            ) : null}
            <meta
                head-key="description"
                name="description"
                content={normalizedDescription}
            />
            <meta
                head-key="og:title"
                property="og:title"
                content={fullTitle}
            />
            <meta
                head-key="og:description"
                property="og:description"
                content={normalizedDescription}
            />
            <meta
                head-key="og:type"
                property="og:type"
                content={type}
            />
            <meta
                head-key="og:site_name"
                property="og:site_name"
                content={appName}
            />
            {currentUrl ? (
                <meta
                    head-key="og:url"
                    property="og:url"
                    content={currentUrl}
                />
            ) : null}
            {imageUrl ? (
                <meta
                    head-key="og:image"
                    property="og:image"
                    content={imageUrl}
                />
            ) : null}
            <meta
                head-key="twitter:card"
                name="twitter:card"
                content={imageUrl ? 'summary_large_image' : 'summary'}
            />
            <meta
                head-key="twitter:title"
                name="twitter:title"
                content={fullTitle}
            />
            <meta
                head-key="twitter:description"
                name="twitter:description"
                content={normalizedDescription}
            />
            {imageUrl ? (
                <meta
                    head-key="twitter:image"
                    name="twitter:image"
                    content={imageUrl}
                />
            ) : null}
        </Head>
    );
}
