<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку formrule.
jimport('joomla.form.formrule');

/**
 * Правило формы для проверки поля приветствия.
 */
class JFormRuleName extends JFormRule
{
	/**
	 * Регулярное выражение.
	 *
	 * @var string
	 */
	protected $regex = '[A-Za-z0-9_]';
}