<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
 
/**
 * Хелпер Album компонента.
 */
abstract class AlbumHelper
{
	/**
	 * Конфигурируем субменю.
	 *
	 * @param string Активный пункт меню.
	 *
	 * @return void
	 */
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(JText::_('COM_ALBUM_SUBMENU_ALBUMS'),
									'index.php?option=com_album', $submenu == 'albums');
		JHtmlSidebar::addEntry(JText::_('COM_ALBUM_SUBMENU_CATEGORIES'),
									'index.php?option=com_categories&view=categories&extension=com_album',
									$submenu == 'categories');

		// Устанавливаем глобальные свойства.
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-album ' .
										'{background-image: url(../media/com_album/images/hello-48x48.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('COM_ALBUM_ADMINISTRATION_CATEGORIES'));
		}
	}

	/**
	 * Получаем доступы для действий.
	 *
	 * @param  int  Id сообщения.
	 *
	 * @return object 
	 */
	public static function getActions($messageId = 0)
	{
		// Подключаем библиотеку доступов.
		jimport('joomla.access.access');
		
		// Определяем имя ассета (ресурса).
		if (empty($messageId)) 
		{
			$assetName = 'com_album';
		}
		else 
		{
			$assetName = 'com_album.album.' . (int)$messageId;
		}

		// Получаем список доступных действий для компонента.
		$actions = JAccess::getActions('com_album', 'component');

		// Получаем объект пользователя.
		$user = JFactory::getUser();

		$result = new JObject;
		foreach ($actions as $action)
		{
			// Устанавливаем доступы пользователя для действий.
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}

		return $result;
	}
}