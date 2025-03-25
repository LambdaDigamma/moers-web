import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button-catalyst';
import { Link } from '@/components/ui/link';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { ReactNode } from 'react';
import Event = Modules.Events.Data.Event;

const ShowEvent = ({ event, formattedDate }: { event: Event; formattedDate: string }) => {
    return (
        <>
            <Head title="Veranstaltung"></Head>
            <DefaultContainer>
                <main className="py-10">
                    <div className="mt-8 grid grid-cols-1 gap-6 lg:grid-flow-col-dense lg:grid-cols-3">
                        <div className="space-y-6 lg:col-span-2 lg:col-start-1">
                            <section aria-labelledby="applicant-information-title">
                                <div className="bg-white shadow sm:rounded-lg">
                                    <div className="px-4 py-5 sm:px-6">
                                        <h2
                                            id="applicant-information-title"
                                            className="text-lg leading-6 font-medium text-gray-900"
                                        >
                                            {event.name}
                                        </h2>
                                    </div>

                                    {event.cancelledAt ? <EventCancelledBanner /> : null}

                                    <div className="border-t border-gray-200 px-4 py-5 sm:px-6">
                                        <dl className="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                            <div className="sm:col-span-1">
                                                <dt className="text-sm font-medium text-gray-500">Datum</dt>
                                                <dd className="mt-1 text-sm text-gray-900">{formattedDate}</dd>
                                            </div>
                                            <div className="sm:col-span-1">
                                                <dt className="text-sm font-medium text-gray-500">Kategorie</dt>
                                                <dd className="mt-1 text-sm text-gray-900">
                                                    {/*@if ($event->category)*/}
                                                    {/*{{ $event->category ?? 'n/v' }}*/}
                                                    {/*@else*/}
                                                    {/*n/v*/}
                                                    {/*@endif*/}
                                                </dd>
                                            </div>
                                            <div className="sm:col-span-1">
                                                <dt className="text-sm font-medium text-gray-500">Veranstalter</dt>
                                                <dd className="mt-1 text-sm text-gray-900">
                                                    <div className="flex flex-row items-center space-x-2">
                                                        <div className="size-5 rounded-full border border-gray-100 bg-white"></div>
                                                        <span>moers festival</span>
                                                    </div>
                                                </dd>
                                            </div>
                                            <div className="sm:col-span-1">
                                                <dt className="text-sm font-medium text-gray-500">Ort</dt>
                                                <dd className="mt-1 text-sm text-gray-900"></dd>
                                            </div>
                                            <div className="sm:col-span-2">
                                                <dt className="text-sm font-medium text-gray-500">Beschreibung</dt>
                                                <dd className="mt-1 max-w-prose text-sm text-gray-900">
                                                    {event.description}
                                                    {/*{!! nl2br($event->description) !!}*/}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                    <div>
                                        <Link
                                            href="#"
                                            className="block bg-gray-50 px-4 py-4 text-center text-sm font-medium text-gray-500 hover:text-gray-700 sm:rounded-b-lg"
                                        >
                                            Kalendereintrag laden
                                        </Link>
                                        {/*<a href="{{ $event->ics() }}" download="{{$event->name}}.ics"*/}
                                        {/*   class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">*/}
                                        {/*    Kalendereintrag laden*/}
                                        {/*</a>*/}
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="lg:col-span-1 lg:col-start-3">
                            <section aria-labelledby="organizer-title">
                                <div className="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                                    <h2
                                        id="organizer-title"
                                        className="text-xs font-semibold tracking-wider text-blue-500 uppercase"
                                    >
                                        Organisator
                                    </h2>
                                    <p
                                        id="organizer"
                                        className="mt-1 text-lg font-medium text-gray-900"
                                    >
                                        {/*@if ($event->extras)*/}
                                        {/*{{ $event->extras->get('organizer', 'n/v') }}*/}
                                        {/*@endif*/}
                                    </p>
                                </div>
                            </section>
                            <section
                                aria-labelledby="location-title"
                                className="mt-6"
                            >
                                <div className="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                                    <h2
                                        id="location-title"
                                        className="text-xs font-semibold tracking-wider text-blue-500 uppercase"
                                    >
                                        Veranstaltungsort
                                    </h2>

                                    <div className="mt-1">
                                        <address className="text-sm leading-none text-gray-900">
                                            <p
                                                id="location"
                                                className="text-lg leading-6 font-medium text-gray-900"
                                            >
                                                {/*@if ($event->extras && $event->extras->get('location'))*/}
                                                {/*{{$event->extras->get('location')}}<br/>*/}
                                                {/*@endif*/}
                                            </p>
                                            <div className="mt-3 space-y-2">
                                                <p>
                                                    {/*@if ($event->extras && $event->extras->get('street'))*/}
                                                    {/*{{$event->extras->get('street')}}<br/>*/}
                                                    {/*@endif*/}
                                                </p>
                                                <p>
                                                    {/*@if ($event->extras && $event->extras->get('postcode'))*/}
                                                    {/*{{$event->extras->get('postcode') . " " . $event->extras->get('place')}}*/}
                                                    {/*@endif*/}
                                                </p>
                                            </div>
                                        </address>
                                    </div>

                                    <div className="mt-6 h-44 overflow-hidden rounded-lg bg-gray-100">
                                        <img
                                            src="#"
                                            alt=""
                                            className="h-full w-full object-cover"
                                        />
                                    </div>
                                    <div className="mt-6 flex flex-col justify-stretch">
                                        <Button color="yellow">Navigation starten</Button>
                                        {/*<x-button>Navigation starten</x-button>*/}
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
            </DefaultContainer>
        </>
    );
};

const EventCancelledBanner = () => {
    return (
        <div className="border-t border-gray-200">
            <div className="border-l-4 border-red-400 bg-red-50 p-4">
                <div className="flex">
                    <div className="flex-shrink-0">
                        <svg
                            className="h-5 w-5 text-red-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div className="ml-3">
                        <p className="text-sm text-red-700">Diese Veranstaltung wurde abgesagt.</p>
                    </div>
                </div>
            </div>
        </div>
    );
};

ShowEvent.layout = (page: ReactNode) => <AppLayout children={page} />;

export default ShowEvent;
