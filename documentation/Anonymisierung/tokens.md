# Token-basierter Zugang zum Kummerkasten

## Grundidee

- Jede Bewohnerin / jeder Bewohner erhält einen Zugangs-Token
- Der Token berechtigt zum Zugriff auf den Kummerkasten
- Es gibt kein Login mit Benutzername und Passwort
- Die Tokens werden zufällig generiert und ohne Personenbezug ausgehändigt
- Der Token dient ausschließlich der Zugriffskontrolle, nicht der Identifikation

## Zentrale Anforderung: Anonymität der Tokens

Ein Token ist nur dann anonym, wenn folgende Bedingungen erfüllt sind:

1. **Keine Zuordnung zu einer Person**
   - Es darf keine Liste geben wie: „Token ABC123 gehört Person x“
   - Auch keine indirekte Zuordnung über Ausgabedatum, Raum, Gruppe oder Ausgabeprotokoll

2. **Zufällige Generierung**
   - Tokens müssen mit einem kryptografisch sicheren Zufallszahlengenerator erzeugt werden
   - Nicht erratbar, nicht vorhersehbar und nicht fortlaufend
   - OWASP empfiehlt für sicherheitsrelevante Tokens mindestens 128 Bit Entropie und ausdrücklich einen CSPRNG [79][81]

3. **Keine Rückschlüsse durch Reihenfolge**
   - Tokens dürfen nicht wie `KUKA-0001`, `KUKA-0002`, `KUKA-0003` aufgebaut sein
   - Andernfalls lässt sich aus der Token-Nummer möglicherweise auf die Ausgabereihenfolge schließen

4. **Keine Verknüpfung mehrerer Nachrichten**
   - Wenn derselbe Token bei jeder Nutzung übertragen wird, kann das System erkennen: „Diese Nachrichten stammen vom selben Token.“
   - Damit ist der Token ein Pseudonym, auch wenn kein Name gespeichert wird [77]

5. **Keine Protokollierung der Token-Nutzung**
   - Kein Logging von: welcher Token wann welche Nachricht abgesendet hat
   - Kein Speichern der IP-Adresse zusammen mit dem Token

## Mögliche Token-Varianten

### Variante 1: Statischer Zugangsschlüssel

Jede Person erhält denselben allgemeinen Zugangscode, zum Beispiel für den Wohnkomplex

**Ablauf:**

```text
Alle Bewohner:innen erhalten denselben Code
          |
          v
Formular verlangt Code
          |
          v
PHP-Skript prüft Code
          |
          v
Zugriff erlaubt oder abgelehnt
```

**Vorteile:**
- Sehr einfach umsetzbar
- Keine individuelle Zuordnung möglich
- Token kann nicht mit einer bestimmten Person verknüpft werden

**Nachteile:**
- Wenn der Code weitergegeben wird, haben auch Nicht-Bewohner Zugriff
- Ein einzelnes geleaktes Token kompromittiert den gesamten Zugang
- Keine Möglichkeit, einzelne Tokens zu sperren

**Bewertung:**  
Datenschutztechnisch am stärksten, sicherheitstechnisch aber schwächer

### Variante 2: Mehrere individuelle, aber nicht personengebundene Tokens

Es werden viele zufällige Tokens erzeugt. Jede Person erhält zufällig einen davon. Es wird nicht dokumentiert, welche Person welchen Token erhalten hat.

**Ablauf:**

```text
Admin erzeugt z. B. 200 zufällige Tokens
          |
          v
Tokens werden gemischt und anonym ausgehändigt
          |
          v
Bewohner:in erhält einen zufälligen Token
          |
          v
Formular verlangt Token
          |
          v
PHP-Skript prüft, ob Token gültig ist
          |
          v
Zugriff erlaubt oder abgelehnt
```

**Vorteile:**
- Jeder Token ist einzeln sperrbar
- Verlorene oder weitergegebene Tokens können gelöscht werden
- Keine direkte Personen-Zuordnung, wenn die Ausgabe nicht protokolliert wird

**Nachteile:**
- Wenn derselbe Token mehrfach verwendet wird, sind die Nachrichten über den Token verknüpfbar
- Die Ausgabe muss organisatorisch anonym erfolgen
- Es braucht einen sicheren Ort, an dem gültige Tokens gespeichert oder geprüft werden

**Bewertung:**  
Guter Kompromiss zwischen Zugriffskontrolle und Anonymität, sofern die Token-Nutzung nicht protokolliert wird

### Variante 3: Einmal-Tokens

Jede Person erhält mehrere zufällige Einmal-Tokens. Für jede Nachricht wird ein anderer Token verwendet.

**Ablauf:**

```text
Bewohner erhält Liste mit mehreren Tokens
          |
          v
Für jede Nachricht wird ein neuer Token verwendet
          |
          v
Token wird nach Nutzung ungültig
          |
          v
Nachricht wird per E-Mail weitergeleitet
```

**Vorteile:**
- Nachrichten lassen sich nicht über denselben Token verknüpfen
- Hohe Unlinkability zwischen einzelnen Einreichungen
- Gut geeignet, wenn wirklich mehrere anonyme Nachrichten möglich sein sollen

**Nachteile:**
- Aufwendiger in Verwaltung und Kommunikation
- Bewohner müssen Tokens aufbewahren
- Wenn jemand alle Tokens verliert, kann sie/er nicht mehr schreiben
- Es muss klar geregelt werden, wie neue Tokens nachgefordert werden können, ohne die Anonymität zu gefährden

**Bewertung:**  
Datenschutztechnisch die stärkste Variante, aber praktisch am aufwendigsten

### Variante 4: Kein Token, nur internes Netzwerk

Der Zugriff wird ausschließlich über das interne Netzwerk geregelt

**Ablauf:**

```text
Bewohner:in ist im internen Netz
          |
          v
Firewall / Reverse Proxy prüft Netzwerkzugriff
          |
          v
Zugriff erlaubt
          |
          v
Formular ist erreichbar
```

**Vorteile:**
- Kein Token nötig
- Keine Zuordnung von Token zu Person
- Einfachste Nutzung

**Nachteile:**
- Jede Person im Netz kann zugreifen
- Keine individuelle Sperrmöglichkeit
- Netzwerkzugriff muss zuverlässig abgesichert sein

**Bewertung:**  
Am anonymsten, aber am wenigsten kontrollierbar

## Wie lässt sich Anonymität gewährleisten?

### 1. Tokens kryptografisch sicher erzeugen

- Verwendung eines CSPRNG, zum Beispiel `random_bytes()` in PHP
- Mindestens 128 Bit Entropie; OWASP empfiehlt für Tokens 128 Bit oder mehr [79][88]
- Keine fortlaufenden Nummern
- Keine ableitbaren Muster wie Datum, Hausnummer oder Raumnummer

**Beispiel:**

```php
// 32 zufällige Bytes = 256 Bit Entropie
$token = bin2hex(random_bytes(32));
```

### 2. Token-Nutzung nicht protokollieren

Nicht speichern:

- Welcher Token wurde wann verwendet?
- Von welcher IP wurde der Token verwendet?
- Welche Nachricht wurde mit welchem Token gesendet?
- Wie oft wurde ein Token genutzt?

Sonst entsteht trotz Anonymität ein Bewegungs- bzw. Nutzungsprofil.

### 3. Nachrichten nicht über denselben Token verknüpfen

Wenn derselbe Token mehrfach verwendet wird, gilt:

```text
Nachricht 1 + Token ABC123
Nachricht 2 + Token ABC123
```

Das System kann dann erkennen, dass beide Nachrichten wahrscheinlich von derselben Person stammen. Der Token ist dann ein Pseudonym. [77]

Lösungen:

- Einmal-Tokens verwenden
- akzeptieren, dass mehrere Nachrichten desselben Tokens verknüpfbar sind
- den Token nur als einmaligen Zugangsschlüssel verwenden, nicht als Absender-Kennung

### 5. Tokens sicher speichern oder hashen

Wenn gültige Tokens serverseitig geprüft werden, sollten sie nicht im Klartext in einer einfachen Datei liegen.

Mögliche Maßnahmen:

- Tokens gehasht speichern, zum Beispiel mit SHA-256
- Zugriff auf die Token-Datei oder -Datenbank stark beschränken
- Keine Tokens in öffentlich erreichbaren Verzeichnissen ablegen
- Keine Tokens im Frontend-Code oder in JavaScript-Dateien speichern

**Beispiel:**

```php
$tokenHash = hash('sha256', $token);
```

Beim Prüfen wird der eingegebene Token ebenfalls gehasht und mit dem gespeicherten Hash verglichen

### 6. Sperrmechanismus definieren

Wenn ein Token verloren geht oder weitergegeben wird, muss er gesperrt werden können

Dafür braucht man eine Liste gültiger Tokens, etwa:

```text
Gültige Tokens:
- ABC123...
- DEF456...
- GHI789...
```

Gesperrte Tokens werden entfernt oder als ungültig markiert.

## Nutzwert

| Variante | Anonymität | Zugriffskontrolle | Aufwand | Empfehlung |
|---|---|---|---|---|
| Statischer Code | Sehr hoch | Gering | Sehr gering | Nur wenn Weitergabe akzeptabel ist |
| Zufällige individuelle Tokens | Hoch | Hoch | Mittel | Guter Kompromiss |
| Einmal-Tokens | Sehr hoch | Hoch | Hoch | Beste Anonymität, aufwendig |
| Nur internes Netzwerk | Sehr hoch | Mittel | Gering bis mittel | Gut, wenn das Netzwerk zuverlässig kontrolliert ist |

**Praktischer Vorschlag:**

- Zugriff grundsätzlich über das interne Netzwerk beschränken
- Zusätzlich einen zufälligen, nicht personengebundenen Token verlangen
- Token serverseitig gehasht prüfen
- Token-Nutzung nicht mit IP, Zeitstempel oder Nachricht speichern
- Dokumentieren, dass derselbe Token bei mehrfacher Nutzung technisch verknüpfbar sein kann
- Falls vollständige Unlinkability benötigt wird: Einmal-Tokens verwenden