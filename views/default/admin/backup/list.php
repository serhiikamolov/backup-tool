<?php

/*
 * Display Form To run update from SVN
 *  
 */

//get path to default backup dir specified in plugin settings
$backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');

if (!$backup_dir || !file_exists($backup_dir)) {

    echo '<p><b>'.elgg_echo('backup-tool:bad_backup_dir').'</b></p>';
} else {
    echo "<p>" . elgg_view("input/form", array(
        "id" => 'backup_Form',
        "body" => elgg_view("input/submit", array("value" => "Create a new backup")),
        "action" => "action/backup-tool/create"
    )) . "</p>";
}



$dir = opendir($backup_dir);

//prepeare array with files name
$backups_files = array();
while ($file = readdir($dir)) {
    if ($file != '.' && $file != '..') {
        $backups_files[] = $file;
    }
}

if ($backups_files) {

    //sorting by name
    rsort($backups_files);


    $body = '<div class="elgg-module elgg-module-inline">';
    $body .= '<div class="elgg-head">';
    $body .= '<label><input type="checkbox" id="backups-checkall"> List of existing backups</label>';
    $body .= elgg_view("input/submit", array("value" => elgg_echo("remove"), 'class' => 'float-alt'));
    $body .= '</div>';
    $body .= '<div class="elgg-body">';

    $body .= '<ul class="elgg-list elgg-list-distinct">';

    foreach ($backups_files as $backup) {
        //prepeare link for downloading
        $download_link = elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/backup-tool/download?file=" . $backup);
        $remove_link = elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/backup-tool/remove?file=" . $backup);
        //buttons
        $buttons = '<span class="elgg-subtext">' . number_format(filesize($backup_dir . $backup) / 1048576, 2) . 'M </span>';
        $buttons .= elgg_view("output/url", array("text" => elgg_echo("Download"), "href" => $download_link, "class" => "elgg-button-submit elgg-button"));
        $buttons .= elgg_view("output/confirmlink", array("text" => elgg_echo("remove"), "href" => $remove_link, "class" => "elgg-button-submit elgg-button"));
        //checkbox
        $checkbox = elgg_view("input/checkbox", array('name' => 'file[]', 'value' => $backup));

        $body .= '<li class="elgg-item">
            <div class="elgg-image-block clearfix">
                <div class="elgg-image">
                    ' . $checkbox . '
                </div>
                <div class="elgg-image-alt">
                ' . $buttons . '
                </div>
                <div class="elgg-body">
                    ' . $backup . '
                </div>
            </div>
        </li>';
    }
    $body .= '</ul>';

    $body .= '</div>';
    
    echo elgg_view("input/form",array("id"=>"backups-form","action"=>"action/backup-tool/remove","body"=>$body));
}


closedir($dir);

