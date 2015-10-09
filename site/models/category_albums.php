<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modelitem Joomla.
jimport('joomla.application.component.modelitem');

/**
 * Модель сообщения компонента Album.
 */
class AlbumModelCategory_albums extends JModelItem
{
	/**
	 * Сообщение.
	 *
	 * @var object
	 */
	protected $item;
        
        /**
	 * Возвращает ссылку на объект таблицы.
	 *
	 * @param	type		Тип таблицы
	 * @param	string		Префикс имени класса таблицы. Необязателен.
	 * @param	array		Конифгурационный массив для таблицы. Необязателен.
	 * 
	 * @return	JTable	Объект таблицы.
	 */
	public function getTable($type = 'Album', $prefix = 'AlbumTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Получаем сообщение.
	 * 
	 * @return object Сообщение, которое отображается пользователю.
	 */
	public function getItem() 
	{
            if (!isset($this->item)) 
            {
               $orderSQL = '';
               $catid = $this->getState('album.catid');
               $order = $this->getState('album.order');
               switch ($order) {
                   case 1:
                     $orderSQL = 'h.ordering ASC';
                     break;
                   case 2:
                     $orderSQL = 'h.ordering DESC';
                     break;
                   case 3:
                     $orderSQL = 'h.name DESC';
                     break;
                  default:
                     $orderSQL = 'h.name ASC';
                     break;
               }
                // Конструируем SQL запрос.
                $this->_db->setQuery($this->_db->getQuery(true)
                                ->select('h.*, c.title as category, c.description as catdesc')
                                ->from('#__album as h')
                                ->leftJoin('#__categories as c ON h.catid=c.id')
                                ->where('h.catid=' . (int)$catid.' OR h.catid IN (SELECT id FROM #__categories WHERE parent_id='.(int)$catid.')')
                                ->order($orderSQL));

                if (!$this->item = $this->_db->loadObjectList()) 
                {
                    $this->setError($this->_db->getError());
                }
            }
            return $this->item;
	}
        
	/**
	 * Метод для авто-заполнения состояния модели.
	 * 
	 * Заметка. Вызов метода getState в этом методе приведет к рекурсии.
	 *
	 * @return void
	 */
	protected function populateState() 
	{
		$app = JFactory::getApplication();

		// Получаем Id сообщения из Запроса.
		$catid = $app->input->getInt('catid');
      $order = $app->input->getInt('order');
      
		// Добавляем Id сообщения в состояние модели.
		$this->setState('album.catid', $catid);
      $this->setState('album.order', $order);
		parent::populateState();
	}
}