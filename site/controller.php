<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

/**
 * Контроллер компонента Album.
 */
class AlbumController extends JControllerLegacy
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }
}