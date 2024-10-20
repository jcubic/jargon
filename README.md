## My Jargon File processing files

This repository contain xslt files and php scripts that generate
sqlite databases from Jargon File. Source for the file can be found on
Eric Raymond page http://www.catb.org/jargon/.

The sqlite files are used on error pages for jQuery Terminal see https://terminal.jcubic.pl/404
and [leash shell](https://github.com/jcubic/leash). Both use the same code to create jargon command.

Check Makefile to see what commands was used to generate sqlite database.

## CSV

To create CSV file you can use SQLite CLI:

```bash
$ sqlite3 jargon3.db
sqlite> .headers on
sqlite> .mode csv
sqlite> .output jargon.csv
sqlite> SELECT * FROM term;
sqlite> .quit
```

## License

[CC0 Public Domain](https://creativecommons.org/share-your-work/public-domain/cc0/)
