<?php

/*
 *  Create a new backup file
 */

elgg_load_library("backup_tool");

if ($filename = backup_tool_create_backup()){
     system_messages(elgg_echo("backup-tool:create:success", array($filename)));
}else{
    register_error(elgg_echo("backup-tool:create:fail"));
}