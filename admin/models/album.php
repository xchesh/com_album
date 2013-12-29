<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modeladmin Joomla.
jimport('joomla.application.component.modeladmin');

/**
 * Модель Album.
 */
class AlbumModelAlbum extends JModelAdmin
{
	/**
	 * Возвращает ссылку на объект таблицы, всегда его создавая.
	 *
	 * @param  type    Тип таблицы для подключения.
	 * @param  string  Префикс класса таблицы. Необязателен.
	 * @param  array   Конфигурационный массив. Необязателен.
	 *
	 * @return  JTable  Объект JTable.
	 */
	public function getTable($type = 'Album', $prefix = 'AlbumTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Метод для получения формы.
	 *
	 * @param  array     $data         Данные для формы.
	 * @param  boolean  $loadData  True, если форма загружает свои данные (по умолчанию), false если нет.
	 *
	 * @return mixed  Объект JForm в случае успеха, в противном случае false.
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Получаем форму.
		$form = $this->loadForm('com_album.album', 'album',
								array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Метод для получения скрипта, который будет включен в форму.
	 *
	 * @return  string  Файлы скриптов.
	 */
	public function getScript() 
	{
		return 'administrator/components/com_album/models/forms/album.js';
	}

        public function getImageLoad(){
            
            $load = $this->loadImage($_FILES);
            
            if (empty($load)){
                return false;
            }
            
            return $load;
        }
        
//        protected function loadImage($array){
//            include_once JPATH_SITE.'/administrator/components/com_album/helpers/image.php';
//            
//            if (empty($array)){
//                return false;
//            }
//            $img = new image();
//            $img->dir = 'images/uploads';
//            $img->sub = date('Y-m-d').'/';
//            $return = $img->load();
//            return $return;
//        }

        /**
	 * Метод для получения данных, которые должны быть  загружены в форму.
	 *
	 * @return  mixed  Данные для формы.
	 */
	protected function loadFormData() 
	{
		// Проверка сессии на наличие ранее введеных в форму данных.
		$data = JFactory::getApplication()->getUserState('com_album.edit.album.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Метод для проверки, может ли пользователь удалять существующую запись.
	 * 
	 * @param  object  $record  Объект записи.
	 *
	 * @return  boolean  True, если разрешено удалять запись.
	 */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			return JFactory::getUser()->authorise('core.delete', 'com_album.album.' . (int)$record->id);
		}
	}
}