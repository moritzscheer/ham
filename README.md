DI-12-F

### Namen der Studierenden:

- Moritz Scheer
- Artur Scheling
- (Holger Dirks, der aus formalen Gründen das Projekt nicht bis zum Schluss mitmachen konnte)

### Betrieb und Nutzungsvoraussetzungen:

Vor dem Betrieb muss die php.ini-Datei abgeändert werden:
- In der php.ini müssen die folgende Extensions unkommentiert werden:
    - sqlite3
    - pdo_sqlite

- Gebenenfalls muss ebenso folgende extensions eingefügt werden:
  - extension=bz2
  - extension=php_pdo_sqlite.dll
  - extension=php_pdo_mysql.dll
  - extension=php_sqlite3.dll

Zum Betrieb der Website wird als erstes via Xampp der Apache-Server gestartet und die index.php ausgeführt. 
Die index.php befindet sich im Ordner "pages".

Weitere Voraussetzungen und Informationen:
- Anmeldedaten eines Beispielsnutzers:
    - Email: test@uni.de
    - Passwort: 1

### Funktionalitäten

Als unangemeldeter und angemeldeter Nutzer:

- Beim Klicken auf das "ham"-Logo im Navigationsteil, wird man auf die Homepage geleitet
- Man kann alle Veranstaltungen und registrierten Bands sehen/finden
- Bei den Veranstaltungen kann man sich das Profil des Veranstalters ansehen
- Auf der Seite der "Bands" kann man nach einer Band suchen (durch Eingabe des Namens)
- Man kann die Einträge in "Bands" nach Namen und Genre sortieren (alphabetische Sortierung beim Namen und Genre) lassen
- Auf der Seite der "Events" kann man nach Veranstaltungen suchen. Dies geschieht entweder durch eintippen des Namens oder durch die Eingabe eines Datums
- Man kann die Veranstaltungen nach Namen(alphabetische Sortierung) und Datum sortieren lassen

Als unangemeldeter Nutzer:

- Man kann sich als Nutzer registrieren (Veranstalter oder Musiker)
- Daten die bei der Registration erhoben werden: 
  Name(Vor- und Nachname), Telefonnummer(optional), Adresse(Straße, Hausnummmer, Postleitzahl, Stadt)(optional), Typ(Veranstalter oder Musiker), Genre(optional), Mitglieder(optional), weitere Bemerkungen(optional), Email, Passwort und Zustimmung des Impressums, Nutzungsbedingungen und Datenschutzrichtlinien 
- Beim Anmelden kann man über einen Haken angeben, dass man angemeldet bleiben soll

Als angemeldeter Nutzer (Veranstalter oder Musiker):

- Man kann alle Veranstaltungen und registrierten Bands sehen/finden
- Bei den Veranstaltungen kann man sich das Profil des Veranstalters ansehen

- Nur ein angemeldeter Veranstalter kann eine Veranstaltung erstellen (dies impliziert, dass er ebenso registriert ist)
- Beim Erstellen einer Veranstaltung werden folgende Daten angegeben: Veranstaltungsname, Veranstaltungort, Datum und Uhrzeit, Anforderungen, Beschreibung und ein Veranstaltungsbild
- Ein angemeldeter Veranstalter kann die eigenen erstellten Veranstaltungen bearbeiten oder die Veranstaltung löschen
- Beim bearbeiten der Veranstaltung kann der angemeldete Veranstalter alle Daten ändern, die beim erstellen erhoben wurden


- Wenn man als Nutzer(Veranstalter oder Musiker) registriert ist, kann man sich anmelden
- Ein angemeldeter Nutzer kann sein Profil ansehen und bearbeiten
- Daten, die man beim Profil bearbeiten kann: Name, Nachname, Telefonnummer, Straße, Hausnummer, Postleitzahl, Stadt, Typ(Veranstalter oder Musiker), Genre, Mitglieder, weitere Bemerkungen, Profilbild, hinzufügen weiterer Bilder, ändern des Banners und die Zustimmung des Impressums, Nutzungsbedingungen und Datenschutzrichtlinien
- Ein angemeldeter Nutzer kann das Passwort für seinen Account ändern
- Ein angemeldeter Nutzer kann ein Profilbild hinzufügen oder ändern und weitere Bilder zum Profil hinzufügen
- Ein angemeldeter Nutzer kann seinen Account löschen
- Ein angemeldeter Nutzer kann sich abmelden

"Besondere Funktion":
- Ein angemeldeter Nutzer kann sich die Veranstaltungen in seiner Nähe anzeigen lassen
  Dabei kann der angemeldeter Nutzer ein Radius angeben indem sich die Veranstaltungen (Veranstaltungsort) befindet

### Nicht bearbeitete Aufgaben

In Aufgabenblatt 6 wurde die Aufgabe 10 nicht bearbeitet.
Sofern ein Nutzer sich mit einer Email anmelden möchte, 
die bereits existiert, wird angegeben, dass die Email oder das Passwort ungültig oder nicht zulässig sind.


### Fehler und Mängel

...


Zu Aufgabenblatt 6

### Weitere Hinweise:

- Löschen von Datenbankeinträgen:
  Beim Löschen von Events (Veranstaltungen)
  werden die Adrssen <ins>nicht</ins> gelöscht,
  weil es mehrere Veranstaltungen geben kann,
  die den selben Veranstaltungsort haben.

- Bilder auf der Webseite:
 
  In der Datenbank sind mehrere Nutzer registriert.
  Es ist davon auszugehen, dass die Veranstalter sich registriert haben.
  Das heißt auch ihre Einträge (Veranstaltungen (Events)) sind von ihnen erstellt worden.
  Das heißt sie haben ihre eigenen Bilder hochgeladen.
  Laut den Nutzungsbedingungen ist das legitim und nicht als rechtswidrig zu sehen.

Dateinamen für die Abgabe:
DI-12-F-Dirks-Scheer-Scheling.zip
