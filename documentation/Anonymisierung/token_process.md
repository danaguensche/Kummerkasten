# Token-Verfahren: Anonymität (Analyse)

## Ausgangspunkt

Priorität 1 ist Anonymität, danach kommt leichte Bedienbarkeit. Zugangskontrolle ist nachrangig.

Missbrauch durch Nicht-Bewohner = Spam oder Falschmeldungen, kein Datenabfluss. Das Risiko ist klein, deshalb darf Kontrolle gegenüber Anonymität zurückstehen.

## Problem beim aktuellen Diagramm

Ansprechperson fordert Token an und gibt es persönlich weiter.
Kommt kurz danach eine Nachricht, kann sie den Absender erraten (Zeitpunkt, Haus). Und das ist genau die Person, vor der Kinder sich schützen wollen, wenn es um Beschwerden geht.

Dazu kommt: wenige Nutzer, seltene Nachrichten. Dann fällt schon das Token-Holen auf. Auch ganz ohne Token wären Rückschlüsse über Haus, Thema und Schreibstil möglich. Die Gruppe möglicher Absender ist einfach klein.

-> Technik kann das nicht lösen, nur verhindern, dass *zusätzliche* Hinweise entstehen.

## Zwei Ursachen, zwei Gegenmaßnahmen

1. **Ausgabe hängt an Person + Zeitpunkt**
   -> Token auf Vorrat an alle, gleichzeitig, egal ob jemand schreiben will (oder Blinde Signatur)
2. **Einreichzeitpunkt sichtbar**
   -> gebündelter Versand (N7), keine Zeitstempel in der Mail, lange Gültigkeit der Tokens

## Varianten im Vergleich

| Variante | Rückschluss durch Ausgabestelle | Aufwand |
|---|---|---|
| Ausgabe bei Bedarf (Diagramm) | möglich | gering |
| Vorrat, einmal an alle | kaum | gering |
| Gemeinsamer Code pro Haus/Einrichtung | nicht möglich | sehr gering |
| Blinde Signatur | nur über Zeitpunkt | hoch |

Blinde Signatur löst nur Ursache 1, und die geht organisatorisch einfacher. Mein Favorit: Vorrat oder gemeinsamer Code. Blinde Signatur als Ausblick dokumentieren (RFC 9474, noch prüfen).

## Weitere Hebel

- Felder reduzieren: Geschlecht und evtl. Haus verkleinern die Gruppe zusätzlich -> Haus ist Wunsch von Herrn Proksch, also mit ihm entscheiden
- Datenschutzhinweis ehrlich formulieren: nicht "anonym", sondern Hinweis, sich im Text nicht selbst zu verraten
- Ansprechperson behandelt Nachrichten vertraulich und versucht nicht, den Absender zu erraten (-> Kapitel 6.2)

## Für die Doku

- 3.5: Restrisiko benennen, keine Anonymitätsggarantie. "Bei wenigen Nutzern und seltenen Nachrichten können Rückschlüsse nicht ausgeschlossen werden."
- Diagramm anpassen (Token-Ausgabe)
- Kapitel 10: Eintrag Token-Ausgabe + Entscheidung Haus/Geschlecht
- Rangfolge festhalten: Anonymität > Bedienbarkeit > Zugangskontrolle

## Offen

- Wer gibt Tokens aus? (Trennung von Rollen)
- Gültigkeit?
- Verlust: wie neues Token ohne Identität preiszugeben?
- Herr Proksch fragen: wie viel Missbrauch wäre vertretbar?