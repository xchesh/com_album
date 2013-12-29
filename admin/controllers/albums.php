<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку controlleradmin Joomla.
jimport('joomla.application.component.controlleradmin');

/**
 * Albums контроллер.
 */
class AlbumControllerAlbums extends JControllerAdmin
{
	/**
	 * Прокси метод для getModel.
	 *
	 * @param string Имя класса модели.
	 * @param string Префикс класса модели.
	 *
	 * @return object Объект модели.
	 */
	public function getModel($name = 'Album', $prefix = 'AlbumModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}