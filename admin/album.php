<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Проверка доступа.
if (!JFactory::getUser()->authorise('core.manage', 'com_album')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Подключаем хелпер.
JLoader::register('AlbumHelper', dirname(__FILE__) . '/helpers/album.php');

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

// Получаем экземпляр контроллера с префиксом Album.
$controller = JControllerLegacy::getInstance('Album');

// Исполняем задачу task из Запроса.
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Перенаправляем, если перенаправление установлено в контроллере.
$controller->redirect();