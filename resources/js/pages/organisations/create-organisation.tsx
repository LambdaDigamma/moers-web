import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Field } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { ReactNode, useEffect, useState } from 'react';
import CreateOrganisationProps = Modules.Management.Data.CreateOrganisationProps;

type CreateOrganisationForm = {
    name: string;
    handle: string;
};

const slugify = (str: string) => {
    return String(str)
        .normalize('NFKD') // split accented characters into their base characters and diacritical marks
        .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
        .trim() // trim leading or trailing whitespace
        .toLowerCase() // convert to lowercase
        .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
        .replace(/\s+/g, '-') // replace spaces with hyphens
        .replace(/-+/g, '-'); // remove consecutive hyphens
};

const CreateOrganisation = ({ host }: CreateOrganisationProps) => {
    const { data, setData, post, processing, errors, reset } = useForm<Required<CreateOrganisationForm>>({
        name: '',
        handle: '',
    });

    const [handleManuallyChanged, setHandleManuallyChanged] = useState(false);

    useEffect(() => {
        if (!handleManuallyChanged) {
            setData('handle', slugify(data.name));
        }
    }, [data.name]);

    const submit = () => {
        post(route('organisations.store'), {
            preserveScroll: true,
        });
    };

    return (
        <div className="mt-8">
            <Card>
                <CardHeader>
                    <CardTitle className="text-xl">Erstelle eine Organisation</CardTitle>
                    <CardDescription>Erstelle eine Organisation für Deinen Verein, Deine Firma oder Dein Geschäft.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form
                        className="space-y-6"
                        onSubmit={submit}
                    >
                        <div>
                            <Label>Name</Label>
                            <Input
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="max-w-md"
                            />
                        </div>
                        <Field>
                            <Label>Handle</Label>
                            <div className="flex flex-row items-center space-x-2">
                                <span className="bg-gray-50">{host}/</span>
                                <Input
                                    value={data.handle}
                                    onChange={(e) => {
                                        setData('handle', e.target.value);
                                        setHandleManuallyChanged(true);
                                    }}
                                    className="max-w-md"
                                />
                            </div>
                        </Field>
                        <Button
                            type="submit"
                            className="mt-4"
                            disabled={processing}
                        >
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            Erstellen
                        </Button>
                    </form>
                </CardContent>
            </Card>
        </div>
    );
};

CreateOrganisation.layout = (page: ReactNode) => <AppLayout children={page} />;

export default CreateOrganisation;
