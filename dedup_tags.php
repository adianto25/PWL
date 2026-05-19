<?php
$mysqli = new mysqli("localhost", "root", "", "db_kuliner");

// Get all tags
$result = $mysqli->query("SELECT * FROM tags ORDER BY id ASC");
$tags = [];
while($row = $result->fetch_assoc()) {
    $tags[] = $row;
}

$seen = [];
$duplicates = [];

foreach($tags as $t) {
    $name = strtolower(trim($t['nama_tag']));
    if (!isset($seen[$name])) {
        $seen[$name] = $t['id'];
    } else {
        $duplicates[] = [
            'id' => $t['id'],
            'keep_id' => $seen[$name]
        ];
    }
}

foreach($duplicates as $dup) {
    $old_id = $dup['id'];
    $new_id = $dup['keep_id'];
    
    // Update tempat_tags to use the new ID, handle ignore if already exists (primary key or unique might block, but let's just do ignore)
    $mysqli->query("UPDATE IGNORE tempat_tags SET tag_id = $new_id WHERE tag_id = $old_id");
    
    // Delete the duplicate mapping if IGNORE didn't update it because it already existed
    $mysqli->query("DELETE FROM tempat_tags WHERE tag_id = $old_id");
    
    // Delete the duplicate tag
    $mysqli->query("DELETE FROM tags WHERE id = $old_id");
    
    echo "Replaced tag ID $old_id with $new_id\n";
}

echo "Deduplication complete.\n";
$mysqli->close();
