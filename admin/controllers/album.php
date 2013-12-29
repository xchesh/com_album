<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class AlbumControllerAlbum extends JControllerForm
{
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int)isset($data[$key]) ? $data[$key] : 0;

		if ($recordId)
			return JFactory::getUser()->authorise('core.edit', 'com_album.album.' . $recordId);
		else
			return parent::allowEdit($data, $key);
	}
}