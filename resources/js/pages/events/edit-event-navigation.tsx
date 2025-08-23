import { Navbar, NavbarItem, NavbarSection } from '@/components/ui/navbar';
import { usePage } from '@inertiajs/react';
import clsx from 'clsx';
import { current } from 'momentum-trail';
import React from 'react';
import Event = Modules.Events.Data.Event;

export const EditEventNavigation = ({ className, ...props }: React.ComponentPropsWithoutRef<'nav'>) => {
    const event = usePage().props.event as Event;
    // Placeholder navigation, adjust as needed
    return (
        <Navbar
            {...props}
            className={clsx(className, '')}
        >
            <NavbarSection>
                <NavbarItem
                    href={route('events.edit', [event.id])}
                    current={current('events.edit', [event.id])}
                >
                    General
                </NavbarItem>
                <NavbarItem
                    href={route('events.venue.edit', [event.id])}
                    current={current('events.venue.edit', [event.id])}
                >
                    Venue
                </NavbarItem>
            </NavbarSection>
        </Navbar>
    );
};
