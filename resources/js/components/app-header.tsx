import { Breadcrumbs } from '@/components/breadcrumbs';
import { AppearanceDropdown } from '@/components/appearance-dropdown';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetClose, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { UserMenuContent } from '@/components/user-menu-content';
import { useInitials } from '@/hooks/use-initials';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem, type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { Calendar, Handshake, LayoutGrid, Menu, Newspaper, Trash2 } from 'lucide-react';
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

const activeItemStyles = 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100';

interface AppHeaderProps {
    breadcrumbs?: BreadcrumbItem[];
}

export function AppHeader({ breadcrumbs = [] }: AppHeaderProps) {
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
                  title: 'News',
                  url: route('news.index'),
                  icon: Newspaper,
              },
              {
                  title: 'Organisationen',
                  url: route('organisations.index'),
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
                  title: 'News',
                  url: route('news.index'),
                  icon: Newspaper,
              },
              {
                  title: 'Organisationen',
                  url: route('organisations.index'),
                  icon: Handshake,
              },
              {
                  title: 'Abfallkalender',
                  url: '/abfallkalender',
                  icon: Trash2,
              },
          ];

    const homeUrl = auth.user ? '/dashboard' : '/';

    return (
        <>
            <div className="border-sidebar-border/80 border-b">
                <div className="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                    {/* Mobile Menu */}
                    <div className="lg:hidden">
                        <Sheet>
                            <SheetTrigger asChild>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    className="mr-2 h-[34px] w-[34px]"
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
                                    <AppLogoIcon className="h-6 w-6 fill-current text-black dark:text-white" />
                                </SheetHeader>
                                <div className="flex h-full flex-1 flex-col space-y-4 p-4">
                                    <div className="flex h-full flex-col justify-between text-sm">
                                        <div className="flex flex-col space-y-4">
                                            {mainNavItems.map((item) => {
                                                const NavIcon = item.icon;

                                                return (
                                                    <SheetClose asChild key={item.title}>
                                                        <Link
                                                            href={item.url}
                                                            className="flex items-center space-x-2 font-medium"
                                                        >
                                                            {NavIcon && <NavIcon className="h-5 w-5" />}
                                                            <span>{item.title}</span>
                                                        </Link>
                                                    </SheetClose>
                                                );
                                            })}
                                        </div>

                                        <div className="flex flex-col space-y-4">
                                            <div className="flex items-center justify-between rounded-lg border border-zinc-200 px-3 py-2 dark:border-white/10">
                                                <span className="font-medium">Darstellung</span>
                                                <AppearanceDropdown />
                                            </div>
                                            {rightNavItems.map((item) => {
                                                const NavIcon = item.icon;

                                                return (
                                                    <a
                                                        key={item.title}
                                                        href={item.url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="flex items-center space-x-2 font-medium"
                                                    >
                                                        {NavIcon && <NavIcon className="h-5 w-5" />}
                                                        <span>{item.title}</span>
                                                    </a>
                                                );
                                            })}
                                        </div>
                                    </div>
                                </div>
                            </SheetContent>
                        </Sheet>
                    </div>

                    <Link href={homeUrl} prefetch className="flex items-center space-x-2">
                        <AppLogo />
                    </Link>

                    {/* Desktop Navigation */}
                    <div className="ml-6 hidden h-full items-center space-x-6 lg:flex">
                        <NavigationMenu className="flex h-full items-stretch">
                            <NavigationMenuList className="flex h-full items-stretch space-x-2">
                                {mainNavItems.map((item) => {
                                    const NavIcon = item.icon;

                                    return (
                                        <NavigationMenuItem
                                            key={item.title}
                                            className="relative flex h-full items-center"
                                        >
                                            <NavigationMenuLink asChild>
                                                <Link
                                                    href={item.url}
                                                    className={cn(
                                                        navigationMenuTriggerStyle(),
                                                        page.url === item.url && activeItemStyles,
                                                        'h-9 cursor-pointer px-3',
                                                    )}
                                                >
                                                    {NavIcon && <NavIcon className="mr-2 h-4 w-4" />}
                                                    {item.title}
                                                </Link>
                                            </NavigationMenuLink>
                                            {page.url === item.url && (
                                                <div className="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"></div>
                                            )}
                                        </NavigationMenuItem>
                                    );
                                })}
                            </NavigationMenuList>
                        </NavigationMenu>
                    </div>

                    <div className="ml-auto flex items-center space-x-2">
                        <div className="relative flex items-center space-x-1">
                            <AppearanceDropdown />
                            <div className="hidden lg:flex">
                                {rightNavItems.map((item) => {
                                    const NavIcon = item.icon;

                                    return (
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
                                                        {NavIcon && <NavIcon className="size-5 opacity-80 group-hover:opacity-100" />}
                                                    </a>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>{item.title}</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </TooltipProvider>
                                    );
                                })}
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
                                    className="inline-flex h-9 items-center rounded-md px-3 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 hover:text-zinc-950"
                                >
                                    Login
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="inline-flex h-9 items-center rounded-md bg-zinc-950 px-3 text-sm font-medium text-white transition hover:bg-zinc-800"
                                >
                                    Registrieren
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
            {breadcrumbs.length > 1 && (
                <div className="border-sidebar-border/70 flex w-full border-b">
                    <div className="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                        <Breadcrumbs breadcrumbs={breadcrumbs} />
                    </div>
                </div>
            )}
        </>
    );
}
