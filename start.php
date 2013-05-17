<?

function backup_tool_init() {


    elgg_register_action("backup-tool/create", elgg_get_plugins_path() . "backup-tool/actions/create.php", "admin");
    elgg_register_action("backup-tool/download", elgg_get_plugins_path() . "backup-tool/actions/download.php", "admin");
    elgg_register_action("backup-tool/remove", elgg_get_plugins_path() . "backup-tool/actions/remove.php", "admin");

    elgg_register_action("backup-tool/schedule-settings", elgg_get_plugins_path() . "backup-tool/actions/schedule-settings.php", "admin");

    elgg_register_library("backup_tool", elgg_get_plugins_path() . "backup-tool/lib/backup-tool.php");

    elgg_extend_view('js/elgg', 'backup-tool/js');

    //register cron jobs only if schedule was enabled
    if (elgg_get_plugin_setting('enable_schedule', 'backup-tool')) {
        $schedule_period = elgg_get_plugin_setting('schedule_period', 'backup-tool');
        $schedule_delete = elgg_get_plugin_setting('schedule_delete', 'backup-tool');

        if ($schedule_period != "never") {
            // Register cron hook for creating backup
            elgg_register_plugin_hook_handler('cron', $schedule_period, 'backup_tool_cron');
        }

        if ($schedule_delete != 'never') {
            // Register cron hook for deletion of selected archived logs
            elgg_register_plugin_hook_handler('cron', $schedule_delete, 'backup_tool_cleanup_cron');
        }
    }
}

function backup_tool_pagesetup() {
    //add menu item on admin panel to update source from svn
    if (elgg_in_context('admin')) {
        elgg_register_admin_menu_item('administer', 'list', 'backups', 0);
        elgg_register_admin_menu_item('administer', 'schedule', 'backups', 0);
    }
}

function backup_tool_cron($hook, $entity_type, $returnvalue, $params) {

    elgg_load_library("backup_tool");
    backup_tool_create_backup();

    return $returnvalue;
}

function backup_tool_cleanup_cron($hook, $entity_type, $returnvalue, $params) {

    elgg_load_library("backup_tool");

    $period = elgg_get_plugin_setting('schedule_delete', 'backup-tool');

    $day = 86400;
    $offset = 0;

    switch ($period) {
        case 'weekly':
            $offset = $day * 7;
            break;
        case 'yearly':
            $offset = $day * 365;
            break;
        case 'monthly':
        default:
            // assume 28 days even if a month is longer. Won't cause data loss.
            $offset = $day * 28;
    }

    backup_tool_cleanup($offset);
    

    return $returnvalue;
}

elgg_register_event_handler('init', 'system', 'backup_tool_init');
elgg_register_event_handler('pagesetup', 'system', 'backup_tool_pagesetup', 1000);