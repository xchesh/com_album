<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление редактирования сообщения.
 */
class AlbumViewAlbum extends JViewLegacy
{
	/**
	 * Сообщение.
	 *
	 * @var array 
	 */
	protected $item;

	/**
	 * Объект формы.
	 *
	 * @var array 
	 */
	protected $form;

	/**
	 * JavaScript файл валидации формы.
	 *
	 * @var string 
	 */
	protected $script;

	/**
	 * Доступы пользователя.
	 *
	 * @var object
	 */
	protected $canDo;

	/**
	 * Отображает представление.
	 *
	 * @return void
	 */
	public function display($tpl = null) 
	{
                    $this->form = $this->get('Form');
                    $this->item = $this->get('Item');
                    $this->script = $this->get('Script');

                    // Есть ли ошибки.
                    if (count($errors = $this->get('Errors'))) 
                    {
                            JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
                    }

                    // Получаем доступы пользователя.
                    $this->canDo = AlbumHelper::getActions($this->item->id);

                    // Устанавливаем панель инструментов.
                    $this->addToolBar();

                    // Отображаем представление.
                    parent::display($tpl);

                    // Устанавливаем документ.
                    $this->setDocument();
        }

	/**
	 * Устанавливает панель инструментов.
	 *
	 * @return void
	 */
	protected function addToolBar() 
	{
		$input = JFactory::getApplication()->input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);

		JToolBarHelper::title($isNew ? JText::_('COM_ALBUM_MANAGER_ALBUM_NEW')
								: JText::_('COM_ALBUM_MANAGER_ALBUM_EDIT'), 'album');

		// Устанавливаем действия для новых и существующих записей.
		if ($isNew) 
		{
			// Для новых записей проверяем право создания.
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::apply('album.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('album.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('album.save2new', 'save-new.png', 'save-new_f2.png',
										'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('album.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			// Для существующих записей проверяем право редактирования.
			if ($this->canDo->get('core.edit'))
			{
				// Мы можем сохранять новую запись.
				JToolBarHelper::apply('album.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('album.save', 'JTOOLBAR_SAVE');

				// Мы можем сохранять  в новую запись, но нужна проверка на создание.
				if ($this->canDo->get('core.create')) 
				{
					JToolBarHelper::custom('album.save2new', 'save-new.png', 'save-new_f2.png',
											'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}

			// Для сохранения копии записи проверяем право создания.
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::custom('album.save2copy', 'save-copy.png', 'save-copy_f2.png',
										'JTOOLBAR_SAVE_AS_COPY', false);
			}
			JToolBarHelper::cancel('album.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
		}
	}

	/**
	 * Метод для установки свойств документа.
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
                $document->addStyleSheet('/media/com_album/css/album.css');
		$document->addScript(JURI::root() . $this->script);
                $document->addScript('/media/com_album/js/upload.js');
                $document->addScript('/media/com_album/js/album.js');
	}
}