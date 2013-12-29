<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку таблиц Joomla.
jimport('joomla.database.table');

/**
 * Класс таблицы Album.
 */
class AlbumTableAlbum extends JTable
{
	/**
	 * Конструктор.
	 *
	 * @param object Коннектор объекта базы данных.
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__album', 'id', $db);
	}
        
        public function check() {
            if ($this->type == '1' && !empty($this->amount) && is_array($this->amount)){
                $this->setImageDB($this->amount, $this->id);
            }
            $this->amount = count($this->amount);
            if (!empty($this->video)){
                $this->video = implode('||', $this->video);
            }else{
                $this->video = '';
            }
            $this->alias = JFilterOutput::stringURLSafe($this->name);
            return parent::check();
        }
        
        protected function setImageDB($arr,$id) 
        { 
            $return = false;
            $db =& JFactory::getDBO();
            $query = "DELETE FROM `#__album_image` WHERE alb_id=".$id; //mysql
            $db->setQuery($query);
            if(!$db->query()){
                echo __LINE__.$db->stderr();
            }
            $insert = 'INSERT INTO `#__album_image`(`alb_id`, `src`, `alt`, `title`, `caption`, `min`) VALUES ';
            foreach ($arr as $name=>$attr){
                $insert .= "('".$id."','".$attr['src']."','".$attr['alt']."','".$attr['title']."','".$attr['caption']."','".$attr['min']."'), ";
            }
            $insert = substr($insert,0,-2);
            $db->setQuery($insert);
            if($db->query()){
                $return = true;
            }else{
                echo __LINE__.$db->stderr();
            }
            return $return;
        }
	/**
	 * Переопределяем bind метод JTable.
	 *
	 * @param  array  Массив значений.
	 *
	 * @return  null|string  Null, если нет ошибок, в противном случае ошибка.
	 */
	public function bind($array, $ignore = '') 
	{
		if (isset($array['params']) && is_array($array['params'])) 
		{
			// Конвертируем поле параметров в JSON строку.
			$parameter = new JRegistry;
			$parameter->loadArray($array['params']);
			$array['params'] = (string)$parameter;
		}

		// Правила.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Переопределяем load метод JTable.
	 *
	 * @param  int         $pk     Первичный ключ.
	 * @param  boolean  $reset  Сбрасывать данные перед загрузкой или нет.
	 *
	 * @return boolean True если все прошло успешно, в противном случае false.
	 */
	public function load($pk = null, $reset = true) 
	{
		if (parent::load($pk, $reset)) 
		{
			// Конвертируем поле параметров в регистр.
			$params = new JRegistry;
			$params->loadString($this->params);
			$this->params = $params;

			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Метод для вычисления уникального имени ассета по умолчанию.
	 * По умолчанию имя берется из формы: `table_name.id`,
	 * где id - это значение первичного ключа таблицы.
	 *
	 * @return  string Название ассета.
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_album.album.' . (int)$this->$k;
	}

	/**
	 * Метод для получения названия ассета для таблицы ассетов.
	 *
	 * @return  string
	 */
	protected function _getAssetTitle()
	{
		return $this->greeting;
	}

	/**
	 * Метод для получения id родителя записи. 
	 *
	 * @return  int Id родителя записи.
	 */
	protected function _getAssetParentId($table = null, $id = null)
	{
		// Получаем таблицу ассетов.
		$assetParent = JTable::getInstance('Asset');

		// По умолчанию: если родительский ассет не найден, то берем глобальный.
		$assetParentId = $assetParent->getRootId();

		// Ищем родительский ассет.
		if (($this->catid) && !empty($this->catid))
		{
			// В качестве родительского ассета записи выступает категория.
			$assetParent->loadByName('com_album.category.' . (int)$this->catid);
		}
		else
		{
			// В качестве родительского ассета записи выступает компонент.
			$assetParent->loadByName('com_album');
		}

		// Возвращаем найденный id родителя записи.
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}
}