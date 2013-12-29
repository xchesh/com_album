<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<div class="albums_all">
    <? foreach ($this->items as $i => $item): 
        $canEdit = JFactory::getUser()->authorise('core.edit', 'com_album.album.' . $item->id); ?>
        <div class="album">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
            <label for="cb<? echo $i;?>">
            <img src="/<?php echo $item->cover; ?>" alt="<?php echo $item->name; ?>" class="album_cover"/>
            <?php if ($canEdit): ?>
                <a href="<?php echo JRoute::_('index.php?option=com_album&task=album.edit&id=' . (int)$item->id); ?>">
                    <span class="album_name"><?php echo JText::_('COM_ALBUM_ALBUM_EDIT_ALBUM').'"'.$item->name.'"'; ?>
                </a>
            <?php else: ?>
                <span class="album_name"><?php echo JText::_('COM_ALBUM_ALBUM_EDIT_ALBUM').'"'.$item->name.'"'; ?></span>
            <?php endif; ?>
            </label>
        </div>
    <?php endforeach; ?>
    <br class="clear clr"/>
</div>