<?php
// No direct access to this file
defined('_JEXEC') or die;

// import the list field type
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('text');

/**
 * katalog Form Field class for the katalog component
 */
class JFormFieldImages extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Images';

    protected function getInput()
	{
        $id = JRequest::getVar('id');
        if (isset($id)){
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__album_image');
            $query->where('alb_id='.$id);
            $query->order('title');
            $db->setQuery((string)$query);
            $images = $db->loadObjectList();
            $return = '';
            if ($images)
            {
                foreach($images as $i=>$img)
                {
                    $return .= '<section>';
                    $return .= '<div class="overIMG"><img src="'.$img->min.'" /></div>';
                    $return .= '<div class="attributs">';
                    $return .= '<input type="text" name="jform[amount]['.$i.'][title]" value="'.$img->title.'" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_TITLE').'"/>';
                    $return .= '<input type="text" name="jform[amount]['.$i.'][alt]" value="'.$img->alt.'" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_ALT').'"/>';
                    $return .= '<textarea name="jform[amount]['.$i.'][caption]" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_CAPTION').'">'.$img->caption.'</textarea>';
                    $return .= '<input type="hidden" name="jform[amount]['.$i.'][src]" value="'.$img->src.'">';
                    $return .= '<input type="hidden" name="jform[amount]['.$i.'][min]" value="'.$img->min.'">';
                    $return .= '</div>';
                    $return .= '<span class="delete" onclick="deleteImg(this);" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_DELETE').'">x</span>';
                    $return .= '</section>';
                }
            }
		    return $return;
        }
	}
}