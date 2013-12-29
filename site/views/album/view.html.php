<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление сообщения компонента Album.
 */
class AlbumViewAlbum extends JViewLegacy
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
                // Получаем изображения альбома
                if ($this->item->type!='2'){
                    $this->images = $this->get('Images');
                }
                
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
		$app = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Так как приложение устанавливает заголовок страницы по умолчанию, 
		// мы получаем его из пункта меню.
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->item->params->def('page_heading', $this->item->params->get('page_title', $menu->title));
		}
		else 
		{
			$this->item->params->def('page_heading', JText::_('COM_ALBUM_DEFAULT_PAGE_TITLE'));
		}

		// Получаем заголовок страницы в браузере из параметров.
		$title = $this->item->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		else
		{
			$title = $this->item->name;
		}

		// Устанавливаем заголовок страницы в браузере.
		$this->document->setTitle($title);
                
                $this->document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
                $this->document->addScript('/media/com_album/js/jquery.gallery.album.js');
                if ($this->item->params->get('script_type')=='1'){
                    $this->document->addScript('/media/com_album/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js');
                    $this->document->addStyleSheet('/media/com_album/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css');
                }
                $this->document->addStyleSheet('/media/com_album/css/album.album.css');
                
                
	}
}