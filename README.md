# My Jargon File processing files

This repository contain xslt files and php scripts that generate
sqlite database and CSV files from Jargon File. Source for the file can be found on
Eric Raymond page http://www.catb.org/jargon/.

The sqlite files are used on error pages for jQuery Terminal see https://terminal.jcubic.pl/404
and [leash shell](https://github.com/jcubic/leash). Both use the same code to create jargon command.
The root directory files contain jQuery Terminal formatting syntax, but in raw directory there
are a version of the jargon file with just the text.

You can compare both jargon.xslt and raw/jargon.xslt to see what is needed to hightlight the dictionary
names e.g. using Markdown or HTML.

## Requirement
To build the files yoursef (after you make any changes) you need:

GNU/Linux system and:

* xsltproc
* php
* php-sqlite3
* expect

## License

[CC0 Public Domain](https://creativecommons.org/share-your-work/public-domain/cc0/)
