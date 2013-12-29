<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление сообщения компонента Album.
 */
class AlbumViewCategory_albums extends JViewLegacy
{
	/**
	 * Сообщение.
	 *
	 * @var object 
	 */
	protected $item;

	/**
	 * Переопределяем метод display класса JViewLegacy.
	 * 
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// Получаем альбом.
		$this->item = $this->get('Item');
                
		// Есть ли ошибки.
		if (count($errors = $this->get('Errors')))
		{
			foreach ($errors as $error)
			{
				JLog::add($error, JLog::ERROR, 'com_album');
			}
		}

		// Подготавливаем документ.
		$this->_prepareDocument();

		// Отображаем представление.
		parent::display($tpl);
	}

	/**
	 * Подготавливает документ.
	 *
	 * @return void
	 */
	protected function _prepareDocument()
	{
                
//                $this->document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
//                $this->document->addScript('/media/com_album/js/jquery.gallery.album.js');
//                if ($this->item->params->get('script_type')=='1'){
//                    $this->document->addScript('/media/com_album/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js');
//                    $this->document->addStyleSheet('/media/com_album/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css');
//                }
                $this->document->addStyleSheet('/media/com_album/css/album.album.css');
                
                
	}
}