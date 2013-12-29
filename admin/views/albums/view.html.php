<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление списка сообщений компонента Album.
 */
class AlbumViewAlbums extends JViewLegacy
{
	/**
	 * Сообщения.
	 *
	 * @var array 
	 */
	protected $items;

	/**
	 * Постраничная навигация.
	 *
	 * @var object
	 */
	protected $pagination;

	/**
	 * Состояние модели.
	 *
	 * @var object
	 */
	protected $state;

	/**
	 * Доступы пользователя.
	 *
	 * @var object
	 */
	protected $canDo;

	/**
	 * Отображает список сообщений.
	 *
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// Получаем данные из модели.
		$this->items = $this->get('Items');

		// Получаем объект постраничной навигации.
		$this->pagination = $this->get('Pagination');

		// Получаем объект состояния модели.
		$this->state = $this->get('State');

		// Есть ли ошибки.
		if (count($errors = $this->get('Errors'))) 
		{
			JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
		}

		// Получаем доступы пользователя.
		$this->canDo = AlbumHelper::getActions();

		// Устанавливаем панель инструментов.
		$this->addToolBar();
                $this->sidebar = JHtmlSidebar::render();
		// Отображаем представление.
		parent::display($tpl);
	}

	/**
	 * Устанавливает панель инструментов.
	 *
	 * @return void
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_ALBUM_MANAGER_ALBUMS'), 'album');
		if ($this->canDo->get('core.create'))
		{
			JToolBarHelper::addNew('album.add');
		}
		if ($this->canDo->get('core.edit'))
		{
			JToolBarHelper::editList('album.edit');
		}
		if ($this->canDo->get('core.delete'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'albums.delete');
		}
		if ($this->canDo->get('core.admin'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_album');
		}
	}
}