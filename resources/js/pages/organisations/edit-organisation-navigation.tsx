import { Navbar, NavbarItem, NavbarSection } from '@/components/ui/navbar';
import { usePage } from '@inertiajs/react';
import clsx from 'clsx';
import { current } from 'momentum-trail';
import React from 'react';
import Organisation = Modules.Management.Data.Organisation;

export const EditOrganisationNavigation = ({ className, ...props }: React.ComponentPropsWithoutRef<'nav'>) => {
    const organisation = usePage().props['organisation'] as Organisation;

    return (
        <Navbar
            {...props}
            className={clsx(className, '')}
        >
            {/*<Link href="/" aria-label="Home">*/}
            {/*    <Logo className="size-10 sm:size-8" />*/}
            {/*</Link>*/}
            <NavbarSection>
                <NavbarItem
                    href={route('organisations.edit', [organisation.slug])}
                    current={current('organisations.edit')}
                >
                    Überblick
                </NavbarItem>
                <NavbarItem
                    href={route('organisations.events.index', [organisation.slug])}
                    current={current('organisations.events.*')}
                >
                    Veranstaltungen
                </NavbarItem>
            </NavbarSection>
        </Navbar>
    );
};
