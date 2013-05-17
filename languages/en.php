<?php

/**
 * Bakup Tool English language file.
 *
 */
$english = array(
    'admin:backups' => 'Backups',
    'admin:backups:list' => 'Latest backups',
    'admin:backups:schedule' => 'Schedule a backup',
    'backup-tool:create' => 'Create a new backup',
    'backup-tool:settings:backup_dir' => 'The full path to the backup directory. For ex. "/var/backups/elgg/".',
    'backup-tool:bad_backup_dir' => '!!! Backup directory is not specified or not exists. Please fill a correct path into <a href="' . elgg_get_site_url() . 'admin/plugin_settings/backup-tool"><u>plugin settings</u></a>',
    'backup-tool:create:success' => '%s was created successfully',
    'backup-tool:create:fail' => 'File was not created because of some errors. Please check path and permissions to the backups directory',
    'backup-tool:message:removed' => '%s file(s) was removed',
    'backup-tool:message:notexists' => 'File %s not exists',
    'backup-tool:message:nofiles' => 'Nothing was selected',
    'backup-tool:schedule:enable' => 'Enable backup scheduling',
    'backup-tool:schedule:period' => 'How often should the backup be created?',
    'backup-tool:schedule:hourly'  => 'Once a hour',
    'backup-tool:schedule:daily' => 'Once a day',
    'backup-tool:schedule:weekly' => 'Once a week',
    'backup-tool:schedule:monthly' => 'Once a month',
    'backup-tool:schedule:yearly' => 'Once a year',
    
    'backup-tool:schedule:delete' => 'Delete backups older than a',
    'backup-tool:schedule:week' => 'week',
    'backup-tool:schedule:month' => 'month',
    'backup-tool:schedule:year' => 'year',
    'backup-tool:schedule:never' => 'never',
    
    'backup-tool:settings:success' => 'Settings of schedule was saved'
);

add_translation('en', $english);
