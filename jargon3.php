<?php


class JargonXML {
    function __construct($file) {
        $doc = new DOMDocument();
        $doc->load($file);
        $this->entries = $doc->getElementsByTagName('entry');
    }
    function find($name) {
        $result = array();
        foreach($this->entries as $entry) {
            $term = self::get_text($entry->getElementsByTagName('term')->item(0)); //->item(0)->childNodes->item(0)->wholeText;
            if (preg_match("/" . $name . "/i", $term)) {
                $found = array(
                    'term' => $term,
                    'def' => preg_replace('/\s{2,}/', ' ', self::get_text($entry->getElementsByTagName('def')->item(0)))
                );
                $abbrev = $entry->getElementsByTagName('abbrev')->item(0);
                if ($abbrev) {
                    foreach ($abbrev->getElementsByTagName('item') as $item) {
                        $found['abbrev'][] = self::get_text($item);
                    }
                }
                $result[] = $found;
            }
        }
        return $result;
    }
    private static function get_text($node) {
        return trim($node->childNodes->item(0)->wholeText);
    }
}

$jargon = new JargonXML('jargon_term.xml');


$db = new SQLiteDatabase('jargon3.db');
$db->query('CREATE TABLE terms(id integer auto_increment, term varchar(255), def text, primary key(id))');
$db->query('CREATE TABLE abbrev(id integer auto_increment, term integer, name varchar(100), primary key(id), foreign key(term) references terms(id))');
foreach($jargon->find('.') as $term) {
    $query = "INSERT INTO terms(term, def) VALUES('" . sqlite_escape_string($term['term']) . "', '" . sqlite_escape_string($term['def']) . "')";
    if ($db->query($query)) {
        $id = $db->lastInsertRowid();
        echo $id;
        if (array_key_exists('abbrev', $term)) {
            foreach ($term['abbrev'] as $abbrev) {
                $query = "INSERT INTO abbrev(term, name) VALUES($id, '" . sqlite_escape_string($abbrev) . "')";
                $db->query($query);
            }
            echo " ; " . count($term['abbrev']) . " abrevs";
        }
        echo "\n";
    }
}

//echo json_encode($jargon->find('dr.*'));
