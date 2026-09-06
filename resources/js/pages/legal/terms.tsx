import { LegalPage, LegalSection, legalLinkClassName } from '@/components/legal-page';
import AppLayout from '@/layouts/app-layout';
import { Link } from '@inertiajs/react';
import type { ReactNode } from 'react';

const sections = [
    { id: 'anbieter', label: 'Anbieter und Geltung' },
    { id: 'leistung', label: 'Leistungsumfang' },
    { id: 'nutzung', label: 'Zulässige Nutzung' },
    { id: 'konto', label: 'Konten und eigene Inhalte' },
    { id: 'drittdaten', label: 'Daten und externe Dienste' },
    { id: 'verfuegbarkeit', label: 'Verfügbarkeit und Updates' },
    { id: 'haftung', label: 'Haftung' },
    { id: 'beendigung', label: 'Beendigung' },
    { id: 'schluss', label: 'Schlussbestimmungen' },
];

function Terms() {
    return (
        <LegalPage
            title="Nutzungsbedingungen"
            description="Bedingungen für die Nutzung von moers.app und der Mein-Moers-Apps für Android und iOS."
            canonicalUrl="https://moers.app/legal/tac"
            sections={sections}
        >
            <LegalSection
                id="anbieter"
                title="1. Anbieter und Geltung"
            >
                <p>
                    Anbieter der Website moers.app und der Mein-Moers-Apps für Android und iOS ist die Inventas GmbH, Heymeshof 7, 47509 Rheurdt,
                    Deutschland. Weitere Pflichtangaben stehen im{' '}
                    <a
                        href="https://inventas.io/impressum"
                        target="_blank"
                        rel="noopener noreferrer"
                        className={legalLinkClassName}
                    >
                        Impressum der Inventas GmbH
                    </a>
                    .
                </p>
                <p>
                    Diese Bedingungen gelten für die Nutzung der Website und der Apps. Mit dem Aufruf oder der Nutzung akzeptieren Sie diese
                    Bedingungen. Für einzelne Dienste Dritter, App-Stores oder Betriebssysteme können zusätzliche Bedingungen des jeweiligen Anbieters
                    gelten.
                </p>
            </LegalSection>

            <LegalSection
                id="leistung"
                title="2. Leistungsumfang"
            >
                <p>
                    Mein Moers ist ein kostenloser Informationsdienst für Moers. Der Dienst bündelt je nach Plattform insbesondere Veranstaltungen,
                    Nachrichten, Orte, Parkinformationen, Abfalltermine, Fahrplanauskünfte und Kraftstoffpreise. Umfang und Darstellung können
                    zwischen Website, Android-App und iOS-App abweichen.
                </p>
                <p>
                    Bestimmte Funktionen benötigen eine Internetverbindung, eine unterstützte Betriebssystemversion oder eine optionale Freigabe wie
                    Standort, Kamera oder Benachrichtigungen. Kosten Ihres Internet-, Mobilfunk- oder Plattformanbieters tragen Sie selbst.
                </p>
            </LegalSection>

            <LegalSection
                id="nutzung"
                title="3. Zulässige Nutzung und Rechte"
            >
                <p>
                    Sie dürfen den Dienst für private und andere rechtmäßige Zwecke verwenden. Sie dürfen den Betrieb nicht stören,
                    Sicherheitsmaßnahmen nicht umgehen, keine automatisierten Massenabfragen ausführen und den Dienst nicht für rechtswidrige Inhalte
                    oder Handlungen verwenden.
                </p>
                <p>
                    Texte, Gestaltung, Marken, Datenbanken und sonstige Bestandteile können urheberrechtlich oder anderweitig geschützt sein. Soweit
                    Quellcode, Daten oder Bestandteile mit einer eigenen Open-Source- oder Datenlizenz veröffentlicht werden, richten sich Ihre Rechte
                    ausschließlich nach dieser Lizenz. Hinweise in den Apps oder den jeweiligen Quelltexten bleiben maßgeblich.
                </p>
            </LegalSection>

            <LegalSection
                id="konto"
                title="4. Konten und eigene Inhalte"
            >
                <p>
                    Die öffentliche Nutzung ist grundsätzlich ohne Konto möglich. Für zusätzliche Website-Funktionen können Sie ein Konto anlegen. Sie
                    müssen richtige Angaben machen, Zugangsdaten schützen und uns einen vermuteten Missbrauch unverzüglich mitteilen. Handlungen über
                    Ihr Konto werden Ihnen zugerechnet, soweit Sie diese zu vertreten haben.
                </p>
                <p>
                    Wenn Sie Inhalte zur Veröffentlichung einreichen, müssen Sie die dafür erforderlichen Rechte besitzen. Die Inhalte dürfen keine
                    Rechte Dritter verletzen und nicht rechtswidrig, irreführend oder schädlich sein. Sie räumen uns die für Speicherung, technische
                    Bearbeitung und Darstellung im Dienst erforderlichen, nicht ausschließlichen Nutzungsrechte ein. Diese Rechte enden, wenn der
                    Inhalt entfernt wird, soweit keine gesetzlichen Pflichten oder berechtigten Sicherungszwecke entgegenstehen.
                </p>
                <p>Wir dürfen offensichtlich rechtswidrige, sicherheitsgefährdende oder sachfremde Inhalte sperren oder entfernen.</p>
            </LegalSection>

            <LegalSection
                id="drittdaten"
                title="5. Daten und externe Dienste"
            >
                <p>
                    Viele Angaben stammen von Behörden, Verkehrsunternehmen, Veranstaltern, Medien, Tankstellen- und Parkdatenanbietern oder anderen
                    Dritten. Wir bemühen uns um eine richtige und aktuelle Darstellung, können diese Daten aber nicht vollständig prüfen. Angaben zu
                    Preisen, Verfügbarkeit, Öffnungszeiten, Fahrten, Terminen und Abholungen können unvollständig, verspätet oder falsch sein. Prüfen
                    Sie zeitkritische Angaben bei der jeweils zuständigen Originalquelle.
                </p>
                <p>
                    Der Dienst ist kein Notfall-, Warn- oder Navigationssystem. Treffen Sie keine sicherheitskritische Entscheidung allein aufgrund
                    der angezeigten Angaben. Beachten Sie bei Navigation und Verkehr stets die tatsächliche Umgebung und die geltenden Regeln.
                </p>
                <p>
                    Externe Links, Karten, App-Stores und Navigationsdienste werden von Dritten betrieben. Für deren Inhalte, Verfügbarkeit und
                    Bedingungen ist der jeweilige Anbieter verantwortlich. Informationen zur Datenverarbeitung enthält unsere{' '}
                    <Link
                        href={route('legal.privacy')}
                        className={legalLinkClassName}
                    >
                        Datenschutzerklärung
                    </Link>
                    .
                </p>
            </LegalSection>

            <LegalSection
                id="verfuegbarkeit"
                title="6. Verfügbarkeit und Updates"
            >
                <p>
                    Wir stellen den Dienst mit angemessener Sorgfalt bereit. Eine unterbrechungsfreie, fehlerfreie oder dauerhaft unveränderte
                    Verfügbarkeit ist nicht geschuldet. Wartung, Sicherheitsmaßnahmen, Ausfälle von Netzen oder Drittanbietern und technische
                    Änderungen können Funktionen vorübergehend einschränken.
                </p>
                <p>
                    Wir können Apps und Website aktualisieren, Funktionen ändern oder nicht mehr unterstützte Funktionen entfernen. Für eine weitere
                    Nutzung kann ein App- oder Betriebssystem-Update erforderlich sein. Wir sind nicht verpflichtet, jede ältere Geräte- oder
                    Systemversion dauerhaft zu unterstützen.
                </p>
            </LegalSection>

            <LegalSection
                id="haftung"
                title="7. Haftung"
            >
                <p>
                    Wir haften unbeschränkt für Vorsatz und grobe Fahrlässigkeit, für Schäden aus der Verletzung von Leben, Körper oder Gesundheit
                    sowie in allen Fällen zwingender gesetzlicher Haftung.
                </p>
                <p>
                    Bei leicht fahrlässiger Verletzung einer wesentlichen Vertragspflicht ist die Haftung auf den bei Vertragsschluss vorhersehbaren,
                    vertragstypischen Schaden begrenzt. Wesentliche Vertragspflichten sind Pflichten, deren Erfüllung die ordnungsgemäße Nutzung erst
                    ermöglicht und auf deren Einhaltung Sie regelmäßig vertrauen dürfen. Im Übrigen ist die Haftung für leichte Fahrlässigkeit
                    ausgeschlossen. Diese Begrenzungen gelten auch zugunsten unserer gesetzlichen Vertreter und Erfüllungsgehilfen.
                </p>
            </LegalSection>

            <LegalSection
                id="beendigung"
                title="8. Beendigung der Nutzung"
            >
                <p>
                    Sie können die Nutzung jederzeit beenden, die Apps deinstallieren und ein vorhandenes Website-Konto im Profil löschen. Wir können
                    Konten bei einem erheblichen oder wiederholten Verstoß gegen diese Bedingungen sperren oder beenden. Soweit zumutbar, informieren
                    wir vorher und geben Gelegenheit zur Abhilfe.
                </p>
                <p>
                    Wir können den gesamten kostenlosen Dienst mit angemessener Vorankündigung einstellen. Eine sofortige Einschränkung bleibt
                    zulässig, wenn sie aus Sicherheitsgründen, wegen rechtlicher Anforderungen oder wegen Umständen außerhalb unseres Einflusses
                    erforderlich ist.
                </p>
            </LegalSection>

            <LegalSection
                id="schluss"
                title="9. Änderungen und Schlussbestimmungen"
            >
                <p>
                    Wir können diese Bedingungen an technische, rechtliche oder funktionale Änderungen anpassen. Die aktuelle Fassung ist dauerhaft
                    unter dieser Adresse verfügbar. Wesentliche Änderungen teilen wir in geeigneter Form mit. Für bereits bestehende Konten gelten
                    Änderungen nur nach Maßgabe des anwendbaren Rechts.
                </p>
                <p>
                    Es gilt deutsches Recht unter Ausschluss des UN-Kaufrechts. Zwingende Verbraucherschutzvorschriften des Staates, in dem Sie Ihren
                    gewöhnlichen Aufenthalt haben, bleiben unberührt. Für Verbraucher gelten die gesetzlichen Gerichtsstände.
                </p>
                <p>
                    Fragen zu diesen Bedingungen richten Sie an{' '}
                    <a
                        href="mailto:info@inventas.io"
                        className={legalLinkClassName}
                    >
                        info@inventas.io
                    </a>
                    .
                </p>
            </LegalSection>
        </LegalPage>
    );
}

Terms.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default Terms;
