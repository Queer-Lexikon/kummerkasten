# askbox
anonym und ohne externe Abhängigkeiten Fragen in einem WordPress per Plugin einsammeln, die dann automatisch als Zitat in Beitragsentwürfen hinterlegt werden. 

## Wie?

das hier ist ein wordpress-plugin. Den Ordner `qu-askbox` ins Plugin-Verzeichnis von einem WordPress werfen (per default `wp-content/plugins`).

Dann gibts einen Shortcode `[askbox]`, die das alles im Frontend händelt. Die eingesandten Fragen landen in einem Zitat-Block in einem Beitragsentwurf.

Für den Beitragstitel und die Benachrichtigungen per Mail Dinge in der `config.php` anpassen.

## Was?

Komplett anonymes Frage-stell-Feature für WordPress. Als Kummerkasten, für Feedback, geheime Zauberformeln...

### The good

- nimmt Fragen vollständig anonym an, keine Daten, kein Stress (:
- keine externen Abhängigkeiten, keine Daten, die irgendwohin gehen, nix, was in eine Datenschutzerklärung muss
- Mailbenachrichtigung über neue Fragen
- nice Mechaniken, die Spam-Einsendungen von vornerein aussortieren
- Mailbenachrichtigungen auch für Spam-Einsendungen (die allerdings keine Beitragsentwürfe bekommen)

### the bad

- Menschen müssen ne Weile suchen, gegebenenfalls, um ihre Frage zu finden.
   - Anonymität hat ihren Preis
   - aber da kommt noch mal eine Verbesserung
- bisher ist das "nur" ein Shortcode
- noch gibts keinen Gutenberg-Block dazu


### the ugly

- schöner Code geht anders
- Doku schreib ich morgen
- Konfiguration kommt in Datei
