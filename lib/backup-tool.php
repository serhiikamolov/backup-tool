<?php

/**
 * 
 * @global type $CONFIG
 * @return string filename of a new backup or false
 */
function backup_tool_create_backup() {

    /*
     *  Create a new backup file
     */
    global $CONFIG;


    $dbuser = $CONFIG->dbuser; //get database user
    $dbpass = $CONFIG->dbpass; //get database password
    $dbname = $CONFIG->dbname; //get database name
    $dbhost = $CONFIG->dbhost;

    $datafolder = elgg_get_data_path(); //get path to sndata folder
    $rootfolder = elgg_get_root_path(); //get path to Elgg folder
//get path to default backup dir specified in plugin settings
    $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');

//prepeare database dump
    $dump_name = $dbname . '-' . date("Ymd") . '.sql';
    $dump_command = "mysqldump --user={$dbuser} --password={$dbpass} --host={$dbhost} --databases {$dbname} > {$backup_dir}{$dump_name}";
//prepare tar file
    $tar_name = $dbname . '-' . date('Ymd') . '.tar';
    $tar_command = "tar -cf {$backup_dir}{$tar_name} {$backup_dir}{$dump_name} {$datafolder} {$rootfolder}";
//compress
    $gzip_command = "gzip {$backup_dir}{$tar_name}";
//remove dump
    $remove_dump_command = "rm {$backup_dir}{$dump_name}";

//if dump with such name already exists then remove it first
    if (file_exists($backup_dir . $tar_name . ".gz")) {
        $remove_command = "rm " . $backup_dir . $tar_name . ".gz";
        shell_exec($remove_command);
    }

    shell_exec($dump_command);
    shell_exec($tar_command);
    shell_exec($gzip_command);
    shell_exec($remove_dump_command);

    if (file_exists($backup_dir . $tar_name . ".gz")) {
        return $tar_name . ".gz";
    }

    return false;
}

function backup_tool_cleanup($offset) {

    elgg_load_library("backup_tool");
    $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');


    $dir = opendir($backup_dir);

    //get size of each backup and comare it with offset
    while ($file = readdir($dir)) {
        if ($file != '.' && $file != '..') {
            $filename = $backup_dir . $file;
            if (is_file($filename)) {
                //if differences between current time and creation time is greater than offset then remove file
                $current_time = time();
                $creation_time = filemtime($filename);
                if ($current_time - $creation_time >= $offset) {
                    unlink($filename);
                }
            }
        }
    }
}