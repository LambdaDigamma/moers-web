import { LegalPage, LegalSection, legalLinkClassName } from '@/components/legal-page';
import AppLayout from '@/layouts/app-layout';
import type { ReactNode } from 'react';

const sections = [
    { id: 'verantwortlicher', label: 'Verantwortlicher' },
    { id: 'geltungsbereich', label: 'Geltungsbereich' },
    { id: 'website', label: 'Website und Benutzerkonto' },
    { id: 'app-daten', label: 'Daten in den Apps' },
    { id: 'standort', label: 'Standort, Karten und Navigation' },
    { id: 'firebase', label: 'Firebase in der iOS-App' },
    { id: 'inhalte', label: 'Externe Inhalte und Dienste' },
    { id: 'speicherdauer', label: 'Speicherdauer' },
    { id: 'rechte', label: 'Ihre Rechte' },
    { id: 'aenderungen', label: 'Änderungen' },
];

function Privacy() {
    return (
        <LegalPage
            title="Datenschutzerklärung"
            description="Informationen zur Verarbeitung personenbezogener Daten auf moers.app sowie in den Mein-Moers-Apps für Android und iOS."
            canonicalUrl="https://moers.app/legal/privacy"
            sections={sections}
        >
            <LegalSection
                id="verantwortlicher"
                title="1. Verantwortlicher"
            >
                <address className="not-italic">
                    Inventas GmbH
                    <br />
                    Heymeshof 7
                    <br />
                    47509 Rheurdt
                    <br />
                    Deutschland
                    <br />
                    E-Mail:{' '}
                    <a
                        href="mailto:info@inventas.io"
                        className={legalLinkClassName}
                    >
                        info@inventas.io
                    </a>
                </address>
                <p>
                    Die Inventas GmbH betreibt moers.app und die Mein-Moers-Apps. Sie ist für die nachfolgend beschriebene Verarbeitung
                    verantwortlich.
                </p>
            </LegalSection>

            <LegalSection
                id="geltungsbereich"
                title="2. Geltungsbereich und Grundsätze"
            >
                <p>
                    Diese Datenschutzerklärung gilt für die Website moers.app und für die Mein-Moers-Apps auf Android und iOS. Die Dienste können
                    grundsätzlich ohne Benutzerkonto verwendet werden. Ein Konto ist nur für zusätzliche Funktionen der Website erforderlich.
                </p>
                <p>
                    Wir verarbeiten nur Daten, die für die Bereitstellung, Sicherheit und Verbesserung der Dienste oder für eine von Ihnen gewählte
                    Funktion erforderlich sind. Rechtsgrundlagen sind insbesondere Art. 6 Abs. 1 lit. b DSGVO für die Bereitstellung gewünschter
                    Funktionen und Art. 6 Abs. 1 lit. f DSGVO für einen sicheren und zuverlässigen Betrieb. Soweit eine Einwilligung erforderlich ist,
                    ist Art. 6 Abs. 1 lit. a DSGVO die Rechtsgrundlage.
                </p>
            </LegalSection>

            <LegalSection
                id="website"
                title="3. Website und Benutzerkonto"
            >
                <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">Aufruf der Website</h3>
                <p>
                    Beim Aufruf übermittelt Ihr Browser technisch erforderliche Daten an unseren Server. Dazu gehören regelmäßig IP-Adresse, Datum und
                    Uhrzeit, angeforderte Adresse, übertragene Datenmenge, HTTP-Status, Referrer sowie Browser- und Betriebssystemangaben.
                    Serverprotokolle dienen der Auslieferung, Fehleranalyse und Abwehr von Angriffen. Rechtsgrundlage ist Art. 6 Abs. 1 lit. f DSGVO.
                </p>

                <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">Konto</h3>
                <p>
                    Wenn Sie ein Konto erstellen, verarbeiten wir Ihren Namen, Ihre E-Mail-Adresse, einen technisch geschützten Passwortwert sowie
                    Angaben zu Anmeldung und Kontoverwaltung. Dies ist zur Durchführung des Nutzungsverhältnisses erforderlich (Art. 6 Abs. 1 lit. b
                    DSGVO). Sie können Ihre Kontodaten im Profil ändern und dort auch die Löschung des Kontos veranlassen.
                </p>

                <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">Cookies und lokaler Speicher</h3>
                <p>
                    Die Website verwendet technisch notwendige Sitzungs- und Sicherheits-Cookies. Sie halten eine Anmeldung aufrecht und schützen
                    Formulare vor missbräuchlichen Anfragen. Die gewählte Darstellung kann im lokalen Speicher des Browsers abgelegt werden. Diese
                    Speicherung ist für die angeforderte Funktion erforderlich. Auf moers.app setzen wir keine Werbe- oder Tracking-Cookies ein.
                </p>
            </LegalSection>

            <LegalSection
                id="app-daten"
                title="4. Daten in den Apps"
            >
                <p>
                    Die Apps rufen Inhalte wie Veranstaltungen, Nachrichten, Orte, Parkdaten, Abfalltermine und Kraftstoffpreise über das Internet ab.
                    Dabei fallen beim jeweiligen Server die üblichen Verbindungsdaten an, insbesondere die IP-Adresse, Zeitpunkt, App- oder
                    Systemversion und die angeforderte Ressource.
                </p>
                <p>
                    Einstellungen und Funktionsdaten werden überwiegend lokal auf Ihrem Gerät gespeichert. Dazu können Benutzerart, bevorzugte
                    Kraftstoffart, Favoriten, Filter, die ausgewählte Abfallstraße, Erinnerungszeiten und eine von Ihnen gespeicherte Parkposition
                    gehören. Sie können diese Daten über die jeweilige Funktion, durch Zurücksetzen der App-Daten oder durch Deinstallation löschen.
                </p>
                <p>
                    Für Erinnerungen verwenden die Apps lokale Benachrichtigungen. Wenn Sie Push-Mitteilungen erlauben, verarbeitet der jeweilige
                    Plattformdienst außerdem eine Geräte- oder Installationskennung, um Mitteilungen zuzustellen. Die Kamera wird nur nach Ihrer
                    Freigabe für Funktionen wie das Scannen eines QR-Codes verwendet. Bilddaten werden dabei auf dem Gerät ausgewertet und nicht als
                    Foto an uns übertragen.
                </p>
            </LegalSection>

            <LegalSection
                id="standort"
                title="5. Standort, Karten und Navigation"
            >
                <p>
                    Standortfunktionen sind optional. Nach Ihrer Systemfreigabe können die Apps Ihren ungefähren oder genauen Standort verwenden, um
                    nahe Orte, Haltestellen, Parkplätze oder Tankstellen zu finden, Entfernungen zu berechnen und eine Kartenansicht auszurichten. Die
                    Freigabe können Sie jederzeit in den Systemeinstellungen ändern.
                </p>
                <p>
                    Bei einer Umkreissuche nach Kraftstoffpreisen werden Koordinaten und Suchparameter an Tankerkönig UG (haftungsbeschränkt)
                    übermittelt. Bei einer Haltestellensuche können Koordinaten an den Verkehrsverbund Rhein-Ruhr AöR (VRR) übermittelt werden. Diese
                    Daten sind erforderlich, um die von Ihnen angeforderte Suche auszuführen (Art. 6 Abs. 1 lit. b DSGVO).
                </p>
                <p>
                    Karten werden unter iOS mit Apple MapKit und unter Android mit Google Maps dargestellt. Dabei können Apple oder Google
                    Verbindungsdaten und Kartennutzung erhalten. Wenn Sie eine externe Navigation starten, gelten zusätzlich die Hinweise des
                    gewählten Navigationsanbieters.
                </p>
                <ul className="list-disc space-y-2 pl-6">
                    <li>
                        <a
                            href="https://www.apple.com/de/legal/privacy/de-ww/"
                            target="_blank"
                            rel="noopener noreferrer"
                            className={legalLinkClassName}
                        >
                            Datenschutz bei Apple
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://policies.google.com/privacy?hl=de"
                            target="_blank"
                            rel="noopener noreferrer"
                            className={legalLinkClassName}
                        >
                            Datenschutzerklärung von Google
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://onboarding.tankerkoenig.de/datenschutz"
                            target="_blank"
                            rel="noopener noreferrer"
                            className={legalLinkClassName}
                        >
                            Datenschutzerklärung von Tankerkönig
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://www.vrr.de/datenschutz/"
                            target="_blank"
                            rel="noopener noreferrer"
                            className={legalLinkClassName}
                        >
                            Datenschutzerklärung des VRR
                        </a>
                    </li>
                </ul>
            </LegalSection>

            <LegalSection
                id="firebase"
                title="6. Firebase in der iOS-App"
            >
                <p>Die iOS-App verwendet Dienste von Google Firebase. Die Android-App verwendet diese Firebase-Dienste derzeit nicht.</p>

                <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">Firebase Analytics</h3>
                <p>
                    Firebase Analytics erfasst pseudonyme Angaben zur App-Nutzung. Dazu können eine Installationskennung, Geräte- und Systemangaben,
                    aufgerufene Bereiche, ausgewählte Inhalte oder Orte, Navigation, gewählte Einstellungen sowie Zeitpunkt und Dauer der Nutzung
                    gehören. Wir verwenden diese Angaben, um Nutzung und Stabilität der App zu verstehen. Rechtsgrundlage ist eine Einwilligung,
                    soweit diese gesetzlich erforderlich ist; im Übrigen ist sie Art. 6 Abs. 1 lit. f DSGVO. Sie können der Verarbeitung jederzeit
                    über die oben genannte Kontaktadresse widersprechen.
                </p>

                <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">Firebase Crashlytics</h3>
                <p>
                    Crashlytics verarbeitet bei einem Absturz oder technischen Fehler Diagnoseangaben. Dazu können Installationskennung, Absturzzeit,
                    App- und Betriebssystemversion, Gerätemodell, Speicherzustand, Funktionsaufrufe und technische Protokolle gehören. Wir nutzen
                    diese Angaben zur Fehlerbehebung und Betriebssicherheit auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Firebase speichert
                    Crashlytics-Ereignisse nach eigenen Angaben in der Regel für 90 Tage.
                </p>

                <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">Firebase Cloud Messaging</h3>
                <p>
                    Firebase Cloud Messaging erzeugt für die iOS-App eine Installationskennung und ein Push-Token. Diese Angaben dienen ausschließlich
                    der technischen Zustellung von Mitteilungen, die Sie erlaubt haben. Rechtsgrundlage ist Art. 6 Abs. 1 lit. b DSGVO.
                </p>
                <p>
                    Anbieter ist Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland. Eine Verarbeitung durch Google LLC und weitere
                    Auftragsverarbeiter außerhalb des Europäischen Wirtschaftsraums kann nicht ausgeschlossen werden. Google verwendet hierfür nach
                    eigenen Angaben anerkannte Übermittlungsmechanismen. Weitere Angaben finden Sie in den{' '}
                    <a
                        href="https://firebase.google.com/support/privacy"
                        target="_blank"
                        rel="noopener noreferrer"
                        className={legalLinkClassName}
                    >
                        Datenschutzinformationen zu Firebase
                    </a>
                    .
                </p>
            </LegalSection>

            <LegalSection
                id="inhalte"
                title="7. Externe Inhalte, Links und Kontakt"
            >
                <p>
                    Wir beziehen einzelne Daten von öffentlichen Stellen und externen Anbietern. Dazu gehören insbesondere Nachrichten,
                    Veranstaltungen, Fahrplan-, Park-, Abfall- und Kraftstoffdaten. Beim reinen Abruf über unsere Server erhält die Quelle regelmäßig
                    keine direkte Information über Sie. Wenn Sie einen externen Link, eine eingebettete Webseite, einen App-Store-Eintrag oder eine
                    Navigation öffnen, baut Ihr Gerät jedoch eine direkte Verbindung zum jeweiligen Anbieter auf. Für diese Verarbeitung ist der
                    Anbieter selbst verantwortlich.
                </p>
                <p>
                    Wenn Sie uns per E-Mail oder über eine Feedback-Funktion kontaktieren, verarbeiten wir Ihre Absenderadresse, den Inhalt und
                    technische Angaben, die Sie selbst mitsenden. Dies dient der Bearbeitung Ihrer Anfrage auf Grundlage von Art. 6 Abs. 1 lit. b oder
                    lit. f DSGVO. Die App öffnet dafür Ihr E-Mail-Programm; eine Nachricht wird erst übertragen, wenn Sie sie absenden.
                </p>
            </LegalSection>

            <LegalSection
                id="speicherdauer"
                title="8. Speicherdauer und Empfänger"
            >
                <p>
                    Wir speichern personenbezogene Daten nur so lange, wie dies für den jeweiligen Zweck erforderlich ist. Serverprotokolle werden
                    nach Ende der für Betrieb und Sicherheit erforderlichen Frist gelöscht, sofern sie nicht zur Aufklärung eines konkreten Vorfalls
                    benötigt werden. Kontodaten werden nach der Löschung des Kontos entfernt; gesetzliche Aufbewahrungspflichten und vorübergehende
                    Sicherungskopien bleiben unberührt. Kontaktanfragen löschen wir, wenn die Bearbeitung abgeschlossen ist und keine Pflicht oder
                    kein berechtigtes Interesse an der weiteren Aufbewahrung besteht.
                </p>
                <p>
                    Zugriff erhalten nur Personen und Dienstleister, die ihn für Betrieb, Hosting, E-Mail, Wartung oder die oben genannten Funktionen
                    benötigen. Auftragsverarbeiter werden nach Art. 28 DSGVO verpflichtet. Eine Weitergabe zu Werbezwecken oder ein Verkauf
                    personenbezogener Daten findet nicht statt.
                </p>
            </LegalSection>

            <LegalSection
                id="rechte"
                title="9. Ihre Rechte"
            >
                <p>Nach Maßgabe der gesetzlichen Voraussetzungen haben Sie insbesondere das Recht auf:</p>
                <ul className="list-disc space-y-2 pl-6">
                    <li>Auskunft über Ihre verarbeiteten Daten (Art. 15 DSGVO),</li>
                    <li>Berichtigung unrichtiger Daten (Art. 16 DSGVO),</li>
                    <li>Löschung oder Einschränkung der Verarbeitung (Art. 17 und 18 DSGVO),</li>
                    <li>Datenübertragbarkeit (Art. 20 DSGVO),</li>
                    <li>Widerspruch gegen eine Verarbeitung auf Grundlage von Art. 6 Abs. 1 lit. e oder f DSGVO (Art. 21 DSGVO), und</li>
                    <li>Widerruf einer Einwilligung mit Wirkung für die Zukunft (Art. 7 Abs. 3 DSGVO).</li>
                </ul>
                <p>
                    Zur Ausübung Ihrer Rechte genügt eine Nachricht an{' '}
                    <a
                        href="mailto:info@inventas.io"
                        className={legalLinkClassName}
                    >
                        info@inventas.io
                    </a>
                    . Sie können sich außerdem bei einer Datenschutzaufsichtsbehörde beschweren. Zuständig ist insbesondere die{' '}
                    <a
                        href="https://www.ldi.nrw.de/"
                        target="_blank"
                        rel="noopener noreferrer"
                        className={legalLinkClassName}
                    >
                        Landesbeauftragte für Datenschutz und Informationsfreiheit Nordrhein-Westfalen
                    </a>
                    .
                </p>
                <p>Eine ausschließlich automatisierte Entscheidung mit rechtlicher oder ähnlich erheblicher Wirkung findet nicht statt.</p>
            </LegalSection>

            <LegalSection
                id="aenderungen"
                title="10. Änderungen dieser Erklärung"
            >
                <p>
                    Wir passen diese Erklärung an, wenn sich Funktionen, Dienstleister oder rechtliche Anforderungen ändern. Die jeweils aktuelle
                    Fassung ist dauerhaft unter dieser Adresse verfügbar. Bei wesentlichen Änderungen weisen wir zusätzlich in geeigneter Form darauf
                    hin.
                </p>
            </LegalSection>
        </LegalPage>
    );
}

Privacy.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default Privacy;
