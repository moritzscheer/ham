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

 - Man kann alle Veranstaltungen und registrierten Bands sehen/finden
 - Man kann sich als Nutzer registrieren (Veranstalter oder Musiker)
 - Wenn man als Nutzer registriert ist, kann man sich anmelden
 - Wenn man als Veranstalter registriert und angemeldet ist, kann man eine Veranstaltung erstellen
 - Beim Erstellen einer Veranstaltung kann man alle möglichen Informationen wie Veranstaltungsname, Beschreibung, Veranstaltungort, Datum und Uhrzeit, Anforderungen und ein Bild hochladen

 - Ein angemeldeter Nutzer kann sein Profil ansehen und bearbeiten
 - Ein angemeldeter Nutzer kann das Passwort für seinen Account ändern
 - Ein angemeldeter Nutzer kann ein Profilbild hinzufügen oder ändern und weitere Bilder zum Porfil hinzufügen
 - Ein angemeldeter Nutzer kann seinen Account löschen
 - Ein angemeldeter Nutzer kann sich abmelden

### Nicht bearbeitete Aufgaben

...

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
