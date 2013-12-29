<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<div class="gallery">

<h1>
    <?php echo $this->item->name; ?>
</h1>
<?php

/*
 * Параметры данного альбома. Скрипт лайтбокс или нет.
 * $this->item->params->get('script_type');
 * 
 */
if ($this->item->type!='2'){
    foreach ($this->images as $image){
        echo '<section class="image">';
        echo '<a rel="album_group" href="'.$image->src.'" title="'.$image->caption.'">';
        echo '<img src="'.$image->min.'" alt="'.$image->alt.'" title="'.$image->title.'">';
        echo '</a>';
        echo '</section>';
    }
}
if($this->item->type!='1'){
    $arr = explode('||',$this->item->video);
    foreach ($arr as $video){
        $uri = parse_url($video);
        echo '<section class="image">';
        echo '<a rel="album_group" class="iframe" href="//www.youtube.com/embed'.$uri['path'].'"><img src="http://img.youtube.com/vi'.$uri['path'].'/0.jpg" alt="YouTube" width="250" /></a>';
        echo '</section>';
    }
}
?>
    
</div>
<br class="clr clear" />