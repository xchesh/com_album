<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
/**
 * Build the route for the com_content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	2.5
 */
function AlbumBuildRoute(&$query)
{
        $app = JFactory::getApplication();
	$menu = $app->getMenu();
        $segments = array();
        $menuItem = $menu->getItems('link','index.php?option=com_album&view=album&id='.$query['id'], true);

        $itemid = $menuItem->id;

        if (isset($itemid)){
            if (empty($query['Itemid']) || $menuItem->query['id']==$query['id'] && $menuItem->query['view']=='album'){
                $query['Itemid']=$itemid; 
            }
        }
        else{
            if(isset($query['id'])){
                if (strpos($query['id'], ':') === false) {//эту проверку можно исключить, но на всякий случай :)
                    $db =&JFactory::getDBO();
                    $DBload = 'SELECT alias FROM #__album WHERE id='.(int)$query['id'];
                    $db->setQuery($DBload);
                    $alias = $db->loadResult();//этот запрос получает алиас из БД
                    $query['id'] = $query['id'].':'.$alias;//устанавливаем $query['id'] равным ид_итема:алиас
                }
                $segments[] = $query['id'];
            }
        }
        unset($query['id']);
        unset($query['view']);
        return $segments;
}
/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 * @since	2.5
 */
function AlbumParseRoute($segments)
{
        $vars = array();
        $count = count($segments);
        if ($count>0){
            list($id, $alias) = explode(':', $segments[$count-1], 2);
            $db =&JFactory::getDBO();
            $DBload = 'SELECT alias FROM #__album WHERE id='.(int)$id;
            $db->setQuery($DBload);
            $alias_db = $db->loadResult();//этот запрос получает алиас из БД
            if (empty($alias_db)){
                return JError::raiseError(404, JText::_('Router Error! Alias not found, Item'));
            }
            if ($alias==$alias_db){
                $vars['view'] = 'album';//ставим вид нужный
                $vars['id'] = (int)$id;//и ид_итема
                return $vars;//делаем "давай дасвидания!"
            }
        }
        return $vars;
}