<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modelitem Joomla.
jimport('joomla.application.component.modelitem');

/**
 * Модель сообщения компонента Album.
 */
class AlbumModelAlbum extends JModelItem
{
	/**
	 * Сообщение.
	 *
	 * @var object
	 */
	protected $item;
        
        protected $images;

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
                $id = $this->getState('album.id');

                // Конструируем SQL запрос.
                $this->_db->setQuery($this->_db->getQuery(true)
                                ->select('h.*, c.title as category')
                                ->from('#__album as h')
                                ->leftJoin('#__categories as c ON h.catid=c.id')
                                ->where('h.id=' . (int)$id));

                if (!$this->item = $this->_db->loadObject()) 
                {
                    $this->setError($this->_db->getError());
                }
                else
                {
                    // Загружаем JSON строку параметров.
                    $params = new JRegistry;
                    $params->loadString($this->item->params);
                    $this->item->params = $params;

                    // Объединяем глобальные параметры с индивидуальными.
                    $params = clone $this->getState('params');
                    $params->merge($this->item->params);
                    $this->item->params = $params;
                }
            }
            return $this->item;
	}
        
        public function getImages() 
	{
            if (!isset($this->images)) 
            {
                $id = $this->getState('album.id');
                $this->_db->setQuery($this->_db->getQuery(true)
                                ->select('h.*')
                                ->from('#__album_image as h')
                                ->where('h.alb_id=' . (int)$id));
                if (!$this->images = $this->_db->loadObjectList()) 
                {
                    $this->setError($this->_db->getError());
                }
            }
            return $this->images;
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
		$id = $app->input->getInt('id');

		// Добавляем Id сообщения в состояние модели.
		$this->setState('album.id', $id);

		// Загружаем глобальные параметры.
		$params = $app->getParams();

		// Добавляем параметры в состояние модели.
		$this->setState('params', $params);

		parent::populateState();
	}
}