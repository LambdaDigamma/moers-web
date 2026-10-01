import { useEffect, useState } from 'react';

export type RubbishPickupType = 'organic' | 'paper' | 'residual' | 'plastic' | 'cuttings';

export type RubbishPickup = {
    date: string;
    type: RubbishPickupType;
};

export const rubbishPickupMeta: Record<RubbishPickupType, { label: string; dotClassName: string }> = {
    residual: { label: 'Restmüll', dotClassName: 'bg-waste-residual' },
    organic: { label: 'Bioabfall', dotClassName: 'bg-waste-organic' },
    paper: { label: 'Papier', dotClassName: 'bg-waste-paper' },
    plastic: { label: 'Gelber Sack', dotClassName: 'bg-waste-plastic' },
    cuttings: { label: 'Grünschnitt', dotClassName: 'bg-waste-cuttings' },
};

export function useRubbishPickups(streetId: number | null, limit = 4) {
    const [pickups, setPickups] = useState<RubbishPickup[]>([]);
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        if (streetId === null) {
            setPickups([]);

            return;
        }

        const abortController = new AbortController();

        setIsLoading(true);

        fetch(`/api/v1/rubbish/streets/${streetId}/pickups`, {
            signal: abortController.signal,
            headers: {
                Accept: 'application/json',
            },
        })
            .then(async (response) => {
                if (!response.ok) {
                    throw new Error('Unable to load pickups');
                }

                const payload = (await response.json()) as { data?: RubbishPickup[] };

                setPickups((payload.data ?? []).slice(0, limit));
            })
            .catch((error: unknown) => {
                if (error instanceof DOMException && error.name === 'AbortError') {
                    return;
                }

                setPickups([]);
            })
            .finally(() => {
                if (!abortController.signal.aborted) {
                    setIsLoading(false);
                }
            });

        return () => abortController.abort();
    }, [streetId, limit]);

    return { pickups, isLoading };
}
