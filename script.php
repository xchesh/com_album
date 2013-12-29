<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

/**
* Файл-скрипт для компонента Album.
*/
class com_AlbumInstallerScript
{
	/**
	 * Метод для установки компонента.
	 *
	 * @param object Класс, который вызывает этом метод.
	 *
	 * @return void
	 */
	function install($parent) 
	{
                $dir = $_SERVER['DOCUMENT_ROOT'].'/images/uploads';
                $parent->getParent()->setRedirectURL('index.php?option=com_album');
                if(!file_exists($dir)){
                    if(!mkdir($dir, 0755)){
                        return $this->error('Ошибка создания каталога.');
                    };
                 }
	}

	/**
	 * Метод для удаления компонента.
	 *
	 * @param object Класс, который вызывает этом метод.
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		echo '<p>' . JText::_('COM_ALBUM_UNINSTALL_TEXT') . '</p>';
	}

	/**
	 * Метод для обновления компонента.
	 *
	 * @param object Класс, который вызывает этом метод.
	 *
	 * @return void
	 */
	function update($parent) 
	{
		echo '<p>' . JText::sprintf('COM_ALBUM_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
	}

	/**
	 * Метод, который исполняется до install/update/uninstall.
	 *
	 * @param  object  $type     Тип изменений: install, update или discover_install
	 * @param  object  $parent  Класс, который вызывает этом метод. Класс, который вызывает этом метод.
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		echo '<p>' . JText::_('COM_ALBUM_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}

	/**
	 * Метод, который исполняется после install/update/uninstall.
	 *
	 * @param  object  $type     Тип изменений: install, update или discover_install
	 * @param  object  $parent  Класс, который вызывает этом метод. Класс, который вызывает этом метод.
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		echo '<p>' . JText::_('COM_ALBUM_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}