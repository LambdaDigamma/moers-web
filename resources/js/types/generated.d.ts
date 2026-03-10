declare namespace App.Data {
    export type MediaData = {
        id: number;
        model_type: string;
        model_id: number;
        uuid: string | null;
        collection_name: string;
        name: string;
        file_name: string;
        mime_type: string | null;
        disk: string;
        conversions_disk: string;
        size: number;
        manipulations: Array<any>;
        custom_properties: Array<any>;
        alt: string | null;
        credits: string | null;
        caption: string | null;
        generated_conversions: Array<any>;
        responsive_images: Array<any>;
        order_column: number;
        created_at: string;
        updated_at: string;
        srcset: string;
        full_url: string;
        responsive_width: number | null;
        responsive_height: number | null;
        preview_url: string | null;
    };
}
declare namespace Modules.Events.Data {
    export type Event = {
        id: number;
        name: string;
        startDate: string | null;
        endDate: string | null;
        description: string | null;
        excerpt: string | null;
        teaser: string | null;
        subtitle: string | null;
        pageId: number | null;
        url: string | null;
        calendarUrl: string | null;
        category: string | null;
        collection: string | null;
        attendanceMode: string | null;
        isOnline: boolean;
        artists: Array<string>;
        locationName: string | null;
        street: string | null;
        postcode: string | null;
        city: string | null;
        latitude: number | null;
        longitude: number | null;
        organisationName: string | null;
        organisationSlug: string | null;
        organisationLogoPath: string | null;
        organizerStreet: string | null;
        organizerPostcode: string | null;
        organizerCity: string | null;
        organizerPhone: string | null;
        organizerEmail: string | null;
        organizerWebsite: string | null;
        headerImageUrl: string | null;
        createdAt: string | null;
        updatedAt: string | null;
        publishedAt: string | null;
        cancelledAt: string | null;
        archivedAt: string | null;
        deletedAt: string | null;
        subEvents: Array<Modules.Events.Data.Event> | null;
        parentEvent: Modules.Events.Data.Event | null;
    };
    export type EventsCollection = {
        id: number;
        name: string;
        publishMetaAt: string;
        isPreview: boolean;
    };
    export type Track = {
        id: number;
        name: string;
        color: string | null;
        items: Array<any>;
    };
    export type TrackItem = {
        id: number;
        title: string;
        start_date: string;
        duration: number;
        color: string | null;
        href: string | null;
        extras: Array<any>;
    };
}
declare namespace Modules.Management.Data {
    export type CreateOrganisationProps = {
        host: string;
    };
    export type EditOrganisationProps = {
        organisation: Modules.Management.Data.Organisation;
    };
    export type Organisation = {
        id: number;
        name: string;
        slug: string;
        description: string;
        logoPath?: string | null;
        headerPath?: string | null;
        createdAt: string;
        updatedAt: string;
    };
    export type StoreOrganisationRequest = {
        name: string;
        slug: string;
    };
}
declare namespace Modules.Parking.Data {
    export type ParkingArea = {
        id: number;
        name: string;
        slug: string;
        capacity: number | null;
        occupied: number | null;
        state: string | null;
        updated_at: string | null;
    };
}
