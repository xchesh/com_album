<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

$app = JFactory::getApplication('site');
$componentParams = $app->getParams('com_album');
$param1 = $componentParams->get('font_bg_color_album', 'rgb(0, 169, 201)');
$param2 = $componentParams->get('font_color_album', 'rgb(255, 255, 255)');
$param3 = $componentParams->get('bg_color_album', 'none');
$param4 = $componentParams->get('border_radius_album', '0');
$param5 = $componentParams->get('width_album', '46%');
$param6 = $componentParams->get('height_album', '200px');
?>
<style>
    .category_albums section a span
    {
        background: <? echo $param1;?>;
        color: <? echo $param2; ?>;
    }
    .category_albums section
    {
        background: <? echo $param3; ?>;
        border-radius: <? echo $param4; ?>;
        width: <? echo $param5; ?>;
        max-width: <?  echo $param5; ?>;
        height: <? echo $param6; ?>;
    }
</style>
<div class="category_albums">
<?php
echo '<h1>'.$this->item[0]->category.'</h1>';
if(!empty($this->item[0]->catdesc)){
    echo '<div class="cat_desc">'.$this->item[0]->catdesc.'</div>';
}
if (!empty($this->item))
{
    foreach ($this->item as $album){
        echo '<section class="album">';
        echo '<a rel="image_group" href="'.JRoute::_('index.php?option=com_album&view=album&id='.$album->id).'" title="'.$album->name.'">';
        echo '<img src="/'.$album->cover.'" alt="'.$album->name.'" title="'.$album->name.'">';
        echo '<span class="caption_album">'.$album->name.'('.$album->amount.')</span>';
        echo '</a>';
        echo '</section>';
    }
}else{
    echo '<p>'.JText::_('COM_ALBUM_NO_ALBUM_DEFAULT').'</p>';
}
?>
</div>