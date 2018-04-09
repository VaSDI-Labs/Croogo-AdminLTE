<?php
/**
 * @var ViewIDE $this
 * @var array $params
 * @var string $key
 * @var string $message
 */

$pClass = isset($params['class']) ? $params['class'] : null;

switch ($pClass) {
    case "success":
        $class = "success";
        $iconClass = "check";
        break;
    case "error":
        $class = "danger";
        $iconClass = "ban";
        break;
    case "info":
        $class = "info";
        $iconClass = "ban";
        break;
    case "warning":
        $class = "warning";
        $iconClass = "warning";
        break;
    default:
        $class = "info";
        $iconClass = "info";
        break;
} ?>

<div id="<?php echo $key; ?>Message" class="alert alert-<?php echo $class; ?> alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-<?php echo $iconClass; ?>"></i><?php echo Inflector::camelize($class) . "!" ?></h4>
    <?php echo $message; ?>
</div>