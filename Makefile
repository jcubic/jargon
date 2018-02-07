ALL: jargon_term.xml jargon.db

jargon.db: jargon_term.xml
	$(test -e jargon.db && rm jargon.db*)
	php -f jargon.php

jargon_term.xml: jargon_term.xslt jargon.xml
	xsltproc jargon_term.xslt jargon.xml > jargon_term.xml

lajkonik: jargon_lajkonik.xml  jargon_lajkonik.db

jargon_lajkonik.xml: jargon_lajkonik.xslt jargon.xml
	xsltproc jargon_lajkonik.xslt jargon.xml > jargon_lajkonik.xml

jargon_lajkonik.db: 
	php -f jargon.php
