# Anonymisierung des Kummerkastens – Angepasste Architektur

## Technischer Aufbau

- Das Frontend enthält das Formular und übernimmt die grundlegende Eingabevalidierung.
- Es gibt kein Laravel-Backend und keine Datenbank.
- Die Formulardaten werden nicht gespeichert.
- Nach der Validierung sendet das Frontend die Daten an ein kleines PHP-Skript auf dem Webserver.
- Das PHP-Skript verwendet PHPMailer, um die Nachricht per SMTP an die ausgewählte Ansprechperson oder an den Gruppenverteiler zu senden.
- SMTP-Zugangsdaten dürfen nicht im Frontend oder im öffentlich ausgelieferten JavaScript liegen.

**Wichtig:** PHPMailer ist eine PHP-Bibliothek und läuft auf dem Server. Ein reines Frontend kann keine E-Mail über PHPMailer versenden, weil dafür SMTP-Zugangsdaten und eine serverseitige Verarbeitung notwendig sind. [75][61]

## Datenflussdiagramm

```text
[Bewohner:in]
      |
      | Nachricht, Art der Meldung,
      | Haus/Gruppe (optional),
      | Geschlecht (optional),
      | Ansprechperson (optional)
      v
[Frontend-Formular]
      |
      | Grundlegende Validierung im Browser
      | Keine Speicherung, keine Cookies, kein Login
      v
[PHP-Skript / Mail-Endpoint]
      |
      | Erneute serverseitige Validierung
      | Keine Speicherung der Formulardaten
      v
[PHPMailer]
      |
      | SMTP-Versand über TLS
      v
[Mailserver]
      |
      ├─ Ansprechperson ausgewählt
      |     → E-Mail an ausgewählte Person
      |
      └─ Keine Ansprechperson ausgewählt
            → E-Mail an konfigurierbaren Gruppenverteiler
```

## Aktivitätsdiagramm

```text
Start
  ↓
Zugriff über internes Netz prüfen
  ↓
Zugriff erlaubt?
  ├─ nein → Hinweis anzeigen → Ende
  └─ ja ↓
Formular anzeigen
  ↓
Nachricht und Art der Meldung eingeben
  ↓
Haus/Gruppe optional wählen
  ↓
Geschlecht optional wählen
  ↓
Ansprechperson optional wählen
  ↓
Datenschutzhinweis anzeigen
  ↓
Frontend validiert Eingaben
  ↓
Daten an PHP-Skript senden
  ↓
PHP-Skript validiert Eingaben erneut
  ↓
Formulardaten nicht speichern
  ↓
Ansprechperson ausgewählt?
  ├─ ja → E-Mail an ausgewählte Ansprechperson senden
  └─ nein → E-Mail an Gruppenverteiler senden
  ↓
Bestätigung anzeigen
Ende
```

## Sequenzdiagramm

```text
Bewohner:in → Frontend: Formular ausfüllen und absenden
Frontend → Frontend: Eingaben validieren
Frontend → PHP-Skript: POST mit Formulardaten
PHP-Skript → PHP-Skript: Eingaben erneut validieren
PHP-Skript → PHPMailer: E-Mail erstellen
PHPMailer → Mailserver: E-Mail per SMTP versenden
Mailserver → Ansprechperson/Verteiler: E-Mail zustellen
PHP-Skript → Frontend: Erfolg oder Fehler zurückgeben
Frontend → Bewohner:in: Bestätigung anzeigen
```

## Anwendungsfalldiagramm

```text
Akteure:
- Bewohner:in
- Ansprechperson
- Administrator:in

Anwendungsfälle:
- Nachricht anonym einreichen
- Ansprechperson auswählen
- Nachricht per E-Mail erhalten
- Ansprechpersonen verwalten
- Häuser/Gruppen verwalten
- E-Mail-Verteiler konfigurieren
```

## Komponenten- bzw. Bereitstellungsdiagramm

```text
[Bewohner-Gerät im internen Netz]
          |
          v
[Firewall / Reverse Proxy]
          |
          | Zugriff nur aus internem Netz
          v
[Webserver mit Frontend und PHP-Skript]
          |
          | PHPMailer
          v
[SMTP-Server / Mailserver]
          |
          v
[Ansprechperson oder Gruppenverteiler]
```

## UI-Skizze / Wireframe

Das Formular sollte sichtbar machen, dass keine Anmeldung und keine Kontaktdaten erforderlich sind.

```text
+--------------------------------------------+
|           Anonymer Kummerkasten            |
+--------------------------------------------+
|                                            |
| Art der Nachricht:                         |
| [ Sorge / Beschwerde / positive Rückmeldung ] |
|                                            |
| Haus/Gruppe (optional):                    |
| [ Dropdown ]                               |
|                                            |
| Geschlecht (optional):                     |
| [ männlich ] [ weiblich ] [ divers ]       |
|                                            |
| Ansprechperson (optional):                 |
| [ Dropdown ]                               |
|                                            |
| Nachricht:                                 |
| +--------------------------------------+   |
| |                                      |   |
| +--------------------------------------+   |
|                                            |
| Hinweis: Deine Nachricht wird nicht        |
| gespeichert. Sie wird anonym per E-Mail    |
| an die ausgewählte Ansprechperson bzw.     |
| an den Gruppenverteiler weitergeleitet.    |
|                                            |
| [ Absenden ]                               |
+--------------------------------------------+
```

## Entscheidungstabelle

| Frage | Option A | Option B | Entscheidung | Begründung |
|---|---|---|---|---|
| Wie werden Formulardaten behandelt? | In Datenbank speichern | Direkt per E-Mail weiterleiten | Direkt per E-Mail | Keine dauerhafte Speicherung erforderlich |
| Wo erfolgt die Validierung? | Nur im Frontend | Frontend und PHP-Skript | Frontend und PHP-Skript | Frontend für Nutzerfreundlichkeit, Server für Sicherheit |
| Wie erfolgt der Mailversand? | PHP `mail()` | PHPMailer über SMTP | PHPMailer über SMTP | Bessere Fehlerbehandlung, SMTP-Authentifizierung und TLS-Unterstützung |
| Wie wird der Zugriff beschränkt? | Login | Internes Netzwerk | Internes Netzwerk | Kein Login erforderlich, Anonymität bleibt erhalten |
| Wie wird die Ansprechperson ermittelt? | Manuelle Auswahl | Automatische Zuordnung | Manuelle Auswahl | Transparent und datenschutzfreundlich |
| Was passiert ohne Auswahl? | Fehlermeldung | Versand an Gruppenverteiler | Versand an Gruppenverteiler | Nachricht geht nicht verloren |

## Risiko- und Maßnahmentabelle

| Risiko | Auswirkung | Maßnahme |
|---|---|---|
| SMTP-Zugangsdaten im Frontend | Dritte könnten Mails im Namen des Systems versenden | Zugangsdaten ausschließlich serverseitig, etwa in einer geschützten Konfigurationsdatei oder Umgebungsvariable, speichern |
| Frontend-Validierung wird umgangen | Ungültige oder manipulierte Daten werden verarbeitet | PHP-Skript validiert alle Eingaben erneut |
| Mail-Header-Injection | Angreifer kann zusätzliche Empfänger oder Header einschleusen | Eingaben bereinigen, Empfänger nicht direkt aus freiem Text übernehmen, PHPMailer verwenden |
| Unverschlüsselter Mailversand | Nachricht könnte mitgelesen werden | SMTP mit TLS bzw. STARTTLS verwenden |
| Zugriff von außerhalb | Unbefugte können Nachrichten einreichen | Firewall oder Reverse Proxy beschränkt Zugriff auf das interne Netz |
| IP-Adresse wird dauerhaft gespeichert | Absender könnte rückverfolgbar sein | IP nur temporär für Netzwerkprüfung verwenden, nicht speichern |
| Falscher Verteiler konfiguriert | Nachricht erreicht falsche Personen | Verteiler konfigurierbar halten und vor Release testen |
| Fehler beim Mailversand | Bewohner:in erhält keine Rückmeldung, ob Nachricht angekommen ist | Klare Erfolgs- und Fehlermeldung im Frontend; Fehler ohne sensible Details ausgeben |

## Wirtschaftlichkeitsbetrachtung

| Maßnahme | Aufwand | Nutzen | Bewertung |
|---|---:|---|---|
| Kein Laravel-Backend | Gering | Weniger Komplexität, keine Datenbankverwaltung | Sinnvoll |
| Keine Datenbankspeicherung | Gering | Weniger personenbezogene Daten, geringeres Risiko | Sehr sinnvoll |
| Frontend-Validierung | Gering | Schnelle Rückmeldung für Nutzer:innen | Sinnvoll |
| Serverseitige Validierung im PHP-Skript | Gering bis mittel | Schutz vor manipulierten Anfragen | Sehr sinnvoll |
| PHPMailer mit SMTP und TLS | Gering bis mittel | Zuverlässiger und sicherer Mailversand | Sehr sinnvoll |
| Interner Netzwerkzugriff | Mittel | Zugriff nur für Berechtigte | Sinnvoll |
| Konfigurierbarer Verteiler | Gering bis mittel | Wartbarkeit ohne Codeänderung | Sinnvoll |

## Empfohlene Dokumentation

Für die FIAE-Dokumentation würde ich folgende Darstellungen verwenden:

1. **Datenflussdiagramm**  
   Zentrale Darstellung: Formular → PHP-Skript → PHPMailer → Mailserver → Empfänger.

2. **Aktivitätsdiagramm**  
   Ablauf der Eingabe, Validierung, Entscheidung und Mailzustellung.

3. **Sequenzdiagramm**  
   Technische Kommunikation zwischen Frontend, PHP-Skript, PHPMailer und Mailserver.

4. **Anwendungsfalldiagramm**  
   Rollen und Anforderungen auf hoher Ebene.

5. **Komponenten- bzw. Bereitstellungsdiagramm**  
   Technische Umgebung, insbesondere interner Netzwerkzugriff und Mailserver.

6. **UI-Skizze**  
   Formular, optionale Felder und Datenschutzhinweis.

7. **Entscheidungs- und Risikotabelle**  
   Begründung für Verzicht auf Datenbank, Laravel-Backend und Login sowie Behandlung der Mailversand-Risiken.

## Besonders wichtige Formulierung

> „Die Formulardaten werden weder in einer Datenbank noch in Dateien gespeichert. Nach der Validierung im Frontend werden sie an ein serverseitiges PHP-Skript übergeben, das die Eingaben erneut prüft und die Nachricht mithilfe von PHPMailer per SMTP an die ausgewählte Ansprechperson oder an den konfigurierbaren Gruppenverteiler weiterleitet.“

Das ist technisch korrekt und erklärt gleichzeitig, warum trotz „kein Backend“ trotzdem ein kleiner serverseitiger PHP-Endpunkt notwendig ist.