<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modellist Joomla.
jimport('joomla.application.component.modellist');

/**
 * Модель списка сообщений компонента Album.
 */
class AlbumModelAlbums extends JModelList
{

	/**
	* Конструктор.
	*
	* @param array Массив с конфигурационными параметрами.
	*/
	public function __construct($config = array())
	{
		// Добавляем валидные поля для фильтров и сортировки.
		if (empty($config['filter_fields'])) 
		{
			$config['filter_fields'] = array(
				'id', 'id',
				'name', 'name',
				'ordering', 'ordering',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Метод для построения SQL запроса для загрузки списка данных.
	 *
	 * @return string SQL запрос.
	 */
	protected function getListQuery()
	{
		// Создаем новый query объект.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Выбераем поля.
		$query->select('id, name, cover');

		// Из таблицы album.
		$query->from('#__album');

		// Добавляем сортировку.
		$orderCol    = $this->state->get('list.ordering', 'id');
		$orderDirn    = $this->state->get('list.direction', 'desc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	* Метод для авто-заполнения состояния модели.
	*
	* @return void
	*/
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('id', 'desc');
	}
}