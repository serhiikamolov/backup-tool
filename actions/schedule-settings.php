<?php

$enable_schedule = get_input("enable-schedule");
$schedule_period = get_input("schedule-period");
$schedule_delete = get_input("schedule-delete");

elgg_get_plugin_setting($name);

elgg_set_plugin_setting('enable_schedule', $enable_schedule,'backup-tool');
elgg_set_plugin_setting('schedule_period', $schedule_period,'backup-tool');
elgg_set_plugin_setting('schedule_delete', $schedule_delete,'backup-tool');

system_messages(elgg_echo("backup-tool:settings:success"));