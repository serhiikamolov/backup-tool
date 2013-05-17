<?
$enable_schedule = elgg_get_plugin_setting('enable_schedule', 'backup-tool');
$period = elgg_get_plugin_setting('schedule_period', 'backup-tool');
$delete = elgg_get_plugin_setting('schedule_delete', 'backup-tool');
?>

<div>
    <?php
    $options = array("name" => "enable-schedule", "default" => 0, "value"=>1);
    if ($enable_schedule==1){
        $options['checked'] = 'checked';
    }
    echo elgg_view("input/checkbox", $options);
    echo elgg_echo("backup-tool:schedule:enable");
    ?> 
</div>
<div>
    <?php
    echo elgg_echo('backup-tool:schedule:period') . ' ';
    echo elgg_view('input/dropdown', array(
        'name' => 'schedule-period',
        'options_values' => array(
            'never' => elgg_echo('backup-tool:schedule:never'),
            //'hourly' => elgg_echo('backup-tool:schedule:hourly'),
            'daily' => elgg_echo('backup-tool:schedule:daily'),
            'weekly' => elgg_echo('backup-tool:schedule:weekly'),
            'monthly' => elgg_echo('backup-tool:schedule:monthly'),
            'yearly' => elgg_echo('backup-tool:schedule:yearly'),
        ),
        'value' => $period,
    ));
    
    ?>
</div>
<div>
<?php
echo elgg_echo('backup-tool:schedule:delete') . ' ';
echo elgg_view('input/dropdown', array(
    'name' => 'schedule-delete',
    'options_values' => array(
        'never' => elgg_echo('backup-tool:schedule:never'),
        'weekly' => elgg_echo('backup-tool:schedule:week'),
        'monthly' => elgg_echo('backup-tool:schedule:month'),
        'yearly' => elgg_echo('backup-tool:schedule:year')
        
    ),
    'value' => $delete,
));
?>
</div>
<div>
    <?php 
        echo elgg_view("input/submit",array("value"=>elgg_echo("save")));
    ?>
    
</div>

