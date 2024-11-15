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
            $term = self::get_text($entry->getElementsByTagName('term')->item(0));
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
        $first_child = $node->childNodes->item(0);
        if ($first_child->nodeType === 1) {
            return trim($first_child->textContent);
        }
        return $first_child->wholeText;
    }
}

$jargon = new JargonXML($argv[1]);

$db = new SQLite3($argv[2]);
$db->exec('CREATE TABLE terms(id integer auto_increment, term varchar(255), def text, primary key(id))');
$db->exec('CREATE TABLE abbrev(id integer auto_increment, term integer, name varchar(100), primary key(id), foreign key(term) references terms(id))');
foreach($jargon->find('.') as $term) {
    $query = "INSERT INTO terms(term, def) VALUES('" . SQLite3::escapeString($term['term']) . "', '" . SQLite3::escapeString($term['def']) . "')";
    if ($db->exec($query)) {
        $id = $db->lastInsertRowid();
        echo $id;
        if (array_key_exists('abbrev', $term)) {
            foreach ($term['abbrev'] as $abbrev) {
                $query = "INSERT INTO abbrev(term, name) VALUES($id, '" . SQLite3::escapeString($abbrev) . "')";
                $db->exec($query);
            }
            echo " ; " . count($term['abbrev']) . " abrevs";
        }
        echo "\n";
    }
}

//echo json_encode($jargon->find('dr.*'));
