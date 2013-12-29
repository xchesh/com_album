<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Загружаем тултипы.
JHtml::_('bootstrap.tooltip');
$doc = JFactory::getDocument();
$doc->addStyleSheet('/media/com_album/css/albums.css');
$doc->addScript('/media/com_album/js/albums.js')
?>
<form action="<?php echo JRoute::_('index.php?option=com_album'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else: ?>
	<div id="j-main-container">
            <?php endif;?>
            <?php echo $this->loadTemplate('body');?>
            <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
	</div>
</form>