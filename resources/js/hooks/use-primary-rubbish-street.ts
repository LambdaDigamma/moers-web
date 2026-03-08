import { useEffect, useState } from 'react';

export type PrimaryRubbishStreet = {
    id: number;
    name: string;
    street_addition: string | null;
};

const storageKey = 'primary-rubbish-street';

const readPrimaryRubbishStreet = (): PrimaryRubbishStreet | null => {
    if (typeof window === 'undefined') {
        return null;
    }

    const rawValue = window.localStorage.getItem(storageKey);

    if (rawValue === null) {
        return null;
    }

    try {
        return JSON.parse(rawValue) as PrimaryRubbishStreet;
    } catch {
        window.localStorage.removeItem(storageKey);

        return null;
    }
};

export function usePrimaryRubbishStreet() {
    const [primaryStreet, setPrimaryStreetState] = useState<PrimaryRubbishStreet | null>(null);
    const [isLoaded, setIsLoaded] = useState(false);

    useEffect(() => {
        setPrimaryStreetState(readPrimaryRubbishStreet());
        setIsLoaded(true);
    }, []);

    const setPrimaryStreet = (street: PrimaryRubbishStreet) => {
        setPrimaryStreetState(street);

        if (typeof window !== 'undefined') {
            window.localStorage.setItem(storageKey, JSON.stringify(street));
        }
    };

    const clearPrimaryStreet = () => {
        setPrimaryStreetState(null);

        if (typeof window !== 'undefined') {
            window.localStorage.removeItem(storageKey);
        }
    };

    return {
        primaryStreet,
        isLoaded,
        setPrimaryStreet,
        clearPrimaryStreet,
    } as const;
}
