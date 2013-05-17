<?php

/*
 * Display Form To run update from SVN
 *  
 */

//get path to default backup dir specified in plugin settings
$backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');

if (!$backup_dir || !file_exists($backup_dir)) {
    
    echo '<p><b>!!! Backup directory is not specified or not exists !!!</b></p>';
    
} else {
    echo "<p>" . elgg_view("input/form", array(
        "id" => 'backup_Form',
        "body" => elgg_view("input/submit", array("value" => "Create a new backup")),
        "action" => "action/backup-tool/create"
    )) . "</p>";
}


echo "<h3>List of existing backups</h3>";
$dir = opendir($backup_dir);
echo '<ul>';
while ($read = readdir($dir)) {

    if ($read != '.' && $read != '..') {
        //prepeare link for downloading
        $download_link = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/backup-tool/download?file=".$read);
        $remove_link = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/backup-tool/remove?file=".$read);
        //buttons
        
        $buttons  = elgg_view("output/url",array("text"=>elgg_echo("Download"),"href"=>$download_link,"class"=>"elgg-button-submit elgg-button"));
        $buttons .= elgg_view("output/confirmlink",array("text"=>elgg_echo("remove"),"href"=>$remove_link,"class"=>"elgg-button-submit elgg-button"));
        //checkbox
        $checkbox = elgg_view("input/checkbox",array('name'=>'backups[]','value'=>$read));
        echo '<li>'.$checkbox." &nbsp; ". $read ." &nbsp;&nbsp; ".$buttons. ' </li>';
    }
}

echo '</ul>';

closedir($dir);

