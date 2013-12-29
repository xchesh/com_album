<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем логирование.
JLog::addLogger(array('text_file' => 'com_album.php'), JLog::ALL, array('com_album'));

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

// Получаем экземпляр контроллера с префиксом Album.
$controller = JControllerLegacy::getInstance('Album');

// Исполняем задачу task из Запроса.
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Перенаправляем, если перенаправление установлено в контроллере.
$controller->redirect();