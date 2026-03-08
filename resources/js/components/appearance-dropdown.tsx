import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuRadioGroup,
    DropdownMenuRadioItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Appearance, useAppearance } from '@/hooks/use-appearance';
import { Laptop, Moon, SunMedium } from 'lucide-react';

const appearanceOptions: { value: Appearance; label: string }[] = [
    { value: 'light', label: 'Hell' },
    { value: 'dark', label: 'Dunkel' },
    { value: 'system', label: 'Automatisch' },
];

export function AppearanceDropdown() {
    const { appearance, updateAppearance } = useAppearance();

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button
                    variant="ghost"
                    size="icon"
                    className="group h-9 w-9"
                >
                    {appearance === 'light' ? (
                        <SunMedium className="size-4 opacity-80 group-hover:opacity-100" />
                    ) : appearance === 'dark' ? (
                        <Moon className="size-4 opacity-80 group-hover:opacity-100" />
                    ) : (
                        <Laptop className="size-4 opacity-80 group-hover:opacity-100" />
                    )}
                    <span className="sr-only">Darstellung auswaehlen</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent
                align="end"
                className="w-44"
            >
                <DropdownMenuLabel>Darstellung</DropdownMenuLabel>
                <DropdownMenuRadioGroup
                    value={appearance}
                    onValueChange={(value) => updateAppearance(value as Appearance)}
                >
                    {appearanceOptions.map((option) => (
                        <DropdownMenuRadioItem
                            key={option.value}
                            value={option.value}
                        >
                            {option.label}
                        </DropdownMenuRadioItem>
                    ))}
                </DropdownMenuRadioGroup>
            </DropdownMenuContent>
        </DropdownMenu>
    );
}
