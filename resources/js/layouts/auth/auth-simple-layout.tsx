import AuthCardLayout from '@/layouts/auth/auth-card-layout';
import { type PropsWithChildren } from 'react';

interface AuthLayoutProps {
    name?: string;
    title?: string;
    description?: string;
}

export default function AuthSimpleLayout(props: PropsWithChildren<AuthLayoutProps>) {
    return <AuthCardLayout {...props} />;
}
