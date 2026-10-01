import { AppearanceDropdown } from '@/components/appearance-dropdown';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Icon } from '@/components/icon';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { NavigationMenu, NavigationMenuItem, NavigationMenuList, navigationMenuTriggerStyle } from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { UserMenuContent } from '@/components/user-menu-content';
import { useInitials } from '@/hooks/use-initials';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem, type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { Calendar, CircleParking, Handshake, LayoutGrid, Menu, Newspaper, Trash2 } from 'lucide-react';
import AppLogo from './app-logo';
import AppLogoIcon from './app-logo-icon';

const rightNavItems: NavItem[] = [
    // {
    //     title: 'Repository',
    //     url: 'https://github.com/laravel/react-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     url: 'https://laravel.com/docs/starter-kits',
    //     icon: BookOpen,
    // },
];

const activeItemStyles = 'text-foreground';

const heroNavItemStyles =
    'bg-transparent text-[15px] font-medium text-hero-muted hover:bg-hero-surface hover:text-hero-foreground focus:bg-hero-surface focus:text-hero-foreground';

export type AppHeaderVariant = 'default' | 'hero';

interface AppHeaderProps {
    breadcrumbs?: BreadcrumbItem[];
    variant?: AppHeaderVariant;
}

export function AppHeader({ breadcrumbs = [], variant = 'default' }: AppHeaderProps) {
    const isHero = variant === 'hero';
    const page = usePage<SharedData>();
    const { auth } = page.props;
    const getInitials = useInitials();
    const mainNavItems: NavItem[] = auth.user
        ? [
              {
                  title: 'Übersicht',
                  url: '/dashboard',
                  icon: LayoutGrid,
              },
              {
                  title: 'Veranstaltungen',
                  url: '/events',
                  icon: Calendar,
              },
              {
                  title: 'Parken',
                  url: '/parking-areas',
                  icon: CircleParking,
              },
              {
                  title: 'Nachrichten',
                  url: '/news',
                  icon: Newspaper,
              },
              {
                  title: 'Organisationen',
                  url: '/organisations',
                  icon: Handshake,
              },
              {
                  title: 'Abfallkalender',
                  url: '/abfallkalender',
                  icon: Trash2,
              },
          ]
        : [
              {
                  title: 'Veranstaltungen',
                  url: '/events',
                  icon: Calendar,
              },
              {
                  title: 'Abfallkalender',
                  url: '/abfallkalender',
                  icon: Trash2,
              },
              {
                  title: 'Parken',
                  url: '/parking-areas',
                  icon: CircleParking,
              },
              {
                  title: 'Nachrichten',
                  url: '/news',
                  icon: Newspaper,
              },
              {
                  title: 'Organisationen',
                  url: '/organisations',
                  icon: Handshake,
              },
          ];

    const homeUrl = auth.user ? '/dashboard' : '/';

    return (
        <>
            <div className={cn('border-b', isHero ? 'border-hero-divider text-hero-foreground absolute inset-x-0 top-0 z-20' : 'border-border')}>
                <div className={cn('md:max-w-page mx-auto flex items-center px-4', isHero ? 'h-[72px]' : 'h-16')}>
                    {/* Mobile Menu */}
                    <div className="lg:hidden">
                        <Sheet>
                            <SheetTrigger asChild>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    aria-label="Navigationsmenü öffnen"
                                    className={cn('mr-2 h-[34px] w-[34px]', isHero && 'hover:bg-hero-surface hover:text-hero-foreground')}
                                >
                                    <Menu className="h-5 w-5" />
                                </Button>
                            </SheetTrigger>
                            <SheetContent
                                side="left"
                                className="bg-sidebar flex h-full w-64 flex-col items-stretch justify-between"
                            >
                                <SheetTitle className="sr-only">Navigationsmenü</SheetTitle>
                                <SheetHeader className="flex justify-start text-left">
                                    <AppLogoIcon className="text-foreground h-6 w-6 fill-current" />
                                </SheetHeader>
                                <div className="flex h-full flex-1 flex-col space-y-4 p-4">
                                    <div className="flex h-full flex-col justify-between text-sm">
                                        <div className="flex flex-col space-y-4">
                                            {mainNavItems.map((item) => (
                                                <Link
                                                    key={item.title}
                                                    href={item.url}
                                                    className="flex items-center space-x-2 font-medium"
                                                >
                                                    {item.icon && (
                                                        <Icon
                                                            iconNode={item.icon}
                                                            className="h-5 w-5"
                                                        />
                                                    )}
                                                    <span>{item.title}</span>
                                                </Link>
                                            ))}
                                        </div>

                                        <div className="flex flex-col space-y-4">
                                            {!auth.user && (
                                                <Button
                                                    asChild
                                                    variant="outline"
                                                >
                                                    <Link href={route('login')}>Anmelden</Link>
                                                </Button>
                                            )}
                                            <div className="border-border flex items-center justify-between rounded-lg border px-3 py-2">
                                                <span className="font-medium">Darstellung</span>
                                                <AppearanceDropdown />
                                            </div>
                                            {rightNavItems.map((item) => (
                                                <a
                                                    key={item.title}
                                                    href={item.url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="flex items-center space-x-2 font-medium"
                                                >
                                                    {item.icon && (
                                                        <Icon
                                                            iconNode={item.icon}
                                                            className="h-5 w-5"
                                                        />
                                                    )}
                                                    <span>{item.title}</span>
                                                </a>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            </SheetContent>
                        </Sheet>
                    </div>

                    <Link
                        href={homeUrl}
                        prefetch
                        className="flex items-center space-x-2"
                    >
                        <AppLogo />
                    </Link>

                    {/* Desktop Navigation */}
                    <div className={cn('hidden h-full items-center space-x-6 lg:flex', isHero ? 'mx-auto' : 'ml-6')}>
                        <NavigationMenu className="flex h-full items-stretch">
                            <NavigationMenuList className="flex h-full items-stretch space-x-2">
                                {mainNavItems.map((item, index) => {
                                    const isActive = item.url === '/' ? page.url === '/' : page.url.startsWith(item.url);

                                    return (
                                        <NavigationMenuItem
                                            key={index}
                                            className="relative flex h-full items-center"
                                        >
                                            <Link
                                                href={item.url}
                                                className={cn(
                                                    navigationMenuTriggerStyle(),
                                                    isHero ? heroNavItemStyles : 'text-muted-foreground hover:text-foreground',
                                                    isActive && (isHero ? 'text-hero-foreground' : activeItemStyles),
                                                    'h-9 cursor-pointer px-3',
                                                )}
                                            >
                                                {item.title}
                                            </Link>
                                            {isActive && <div className="bg-accent-500 absolute bottom-0 left-0 h-0.5 w-full translate-y-px"></div>}
                                        </NavigationMenuItem>
                                    );
                                })}
                            </NavigationMenuList>
                        </NavigationMenu>
                    </div>

                    <div className={cn('flex items-center space-x-2', isHero ? 'ml-auto lg:ml-0' : 'ml-auto')}>
                        <div className="relative flex items-center space-x-1">
                            <AppearanceDropdown className={cn('hidden lg:inline-flex', isHero && 'lg:hidden')} />
                            <div className="hidden lg:flex">
                                {rightNavItems.map((item) => (
                                    <TooltipProvider
                                        key={item.title}
                                        delayDuration={0}
                                    >
                                        <Tooltip>
                                            <TooltipTrigger>
                                                <a
                                                    href={item.url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="group text-accent-foreground ring-offset-background hover:bg-accent hover:text-accent-foreground focus-visible:ring-ring ml-1 inline-flex h-9 w-9 items-center justify-center rounded-md bg-transparent p-0 text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                                                >
                                                    <span className="sr-only">{item.title}</span>
                                                    {item.icon && (
                                                        <Icon
                                                            iconNode={item.icon}
                                                            className="size-5 opacity-80 group-hover:opacity-100"
                                                        />
                                                    )}
                                                </a>
                                            </TooltipTrigger>
                                            <TooltipContent>
                                                <p>{item.title}</p>
                                            </TooltipContent>
                                        </Tooltip>
                                    </TooltipProvider>
                                ))}
                            </div>
                        </div>
                        {auth.user ? (
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button
                                        variant="ghost"
                                        className="size-10 rounded-full p-1"
                                    >
                                        <Avatar className="size-8 overflow-hidden rounded-full">
                                            <AvatarImage
                                                src={auth.user.avatar}
                                                alt={auth.user.name}
                                            />
                                            <AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {getInitials(auth.user.name)}
                                            </AvatarFallback>
                                        </Avatar>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    className="w-56"
                                    align="end"
                                >
                                    <UserMenuContent user={auth.user} />
                                </DropdownMenuContent>
                            </DropdownMenu>
                        ) : (
                            <div className="flex items-center gap-2">
                                <Link
                                    href={route('login')}
                                    className={cn(
                                        'hidden items-center rounded-md font-medium transition sm:inline-flex',
                                        isHero
                                            ? cn(heroNavItemStyles, 'h-[38px] px-3.5')
                                            : 'text-muted-foreground hover:bg-accent hover:text-foreground h-9 px-3 text-sm',
                                    )}
                                >
                                    Anmelden
                                </Link>
                                <Link
                                    href={route('register')}
                                    className={cn(
                                        'inline-flex items-center rounded-lg font-semibold transition',
                                        isHero
                                            ? 'bg-hero-foreground text-graphit-900 hover:bg-hero-foreground/90 h-[38px] px-4 text-[15px]'
                                            : 'bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-3.5 text-sm',
                                    )}
                                >
                                    Registrieren
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
            {breadcrumbs.length > 1 && (
                <div className="border-border flex w-full border-b">
                    <div className="text-muted-foreground md:max-w-page mx-auto flex h-12 w-full items-center justify-start px-4">
                        <Breadcrumbs breadcrumbs={breadcrumbs} />
                    </div>
                </div>
            )}
        </>
    );
}
