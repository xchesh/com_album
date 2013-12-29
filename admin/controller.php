<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class AlbumController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = array()) 
	{
                if($_POST['ajax']=='1'){
                    echo $this->imageLoad();
                    exit();
                }

                $input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'Albums'));

		AlbumHelper::addSubmenu('albums');
                
                parent::display($cachable, $urlparams);
                    
	}
        private function imageLoad()
        {
            include_once JPATH_SITE.'/administrator/components/com_album/helpers/image.php';
            
            $img = new image();
            $img->dir = 'images/uploads';
            $img->sub = date('Y-m-d').'/';
            $return = $img->load();
            $html = $this->generateHTML($return);
            if($html)
                return $html;
        }
        
        private function generateHTML($array)
        {
            if(empty($array))
                return false;
            
            $html = '<section>';
            $html .= '<div class="overIMG"><img src="'.$array['min'].'" /></div>';
            $html .= '<div class="attributs">';
            $html .= '<input type="text" name="jform[amount]['.$array['name'].'][title]" value="'.JText::_('COM_ALBUM_ALBUM_FIELD_TITLE').'" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_TITLE').'"/>';
            $html .= '<input type="text" name="jform[amount]['.$array['name'].'][alt]" value="'.JText::_('COM_ALBUM_ALBUM_FIELD_ALT').'" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_ALT').'" />';
            $html .= '<textarea name="jform[amount]['.$array['name'].'][caption]" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_CAPTION').'" >'.JText::_('COM_ALBUM_ALBUM_FIELD_CAPTION').'</textarea>';
            $html .= '<input type="hidden" name="jform[amount]['.$array['name'].'][src]" value="'.$array['link'].'">';
            $html .= '<input type="hidden" name="jform[amount]['.$array['name'].'][min]" value="'.$array['min'].'">';
            $html .= '</div>';
            $html .= '<span class="delete" onclick="deleteImg(this);" title="'.JText::_('COM_ALBUM_ALBUM_FIELD_DELETE').'">x</span>';
            $html .= '</section>';
            
            return $html;
        }
}