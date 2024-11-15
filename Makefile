ALL: jargon.db raw/jargon.db csv

jargon.db: jargon_term.xml
	$(test -e jargon.db && rm jargon.db*)
	php -f jargon.php jargon_term.xml jargon.db

jargon_term.xml: jargon_term.xslt jargon.xml
	xsltproc jargon_term.xslt jargon.xml > jargon_term.xml

raw/jargon.xml: raw/jargon.xslt jargon.xml
	xsltproc raw/jargon.xslt jargon.xml > raw/jargon.xml

abbrev.csv jargon.csv: jargon.db
	./export.exp jargon.db .

raw/abbrev.csv raw/jargon.csv: raw/jargon.db
	./export.exp raw/jargon.db raw

csv: abbrev.csv jargon.csv raw/abbrev.csv raw/jargon.csv

raw/jargon.db: raw/jargon.xml
	$(test -e raw/jargon.db && rm raw/jargon.db*)
	php -f jargon.php raw/jargon.xml raw/jargon.db

