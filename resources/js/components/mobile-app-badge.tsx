import { cn } from '@/lib/utils';

export function MobileAppBadge({ href, platform, className }: { href: string; platform: 'ios' | 'android'; className?: string }) {
    return (
        <a
            href={href}
            target="_blank"
            rel="noreferrer"
            className={cn('inline-flex h-[52px] items-center transition hover:opacity-80 active:scale-95', className)}
        >
            {platform === 'ios' ? (
                <img
                    src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/white/de-de?size=250x83"
                    alt="Laden im App Store"
                    className="h-[52px] w-auto"
                />
            ) : (
                <img
                    src="https://play.google.com/intl/en_us/badges/static/images/badges/de_badge_web_generic.png"
                    alt="Jetzt bei Google Play"
                    className="-mx-[11px] h-[76px] w-auto max-w-none"
                />
            )}
        </a>
    );
}
