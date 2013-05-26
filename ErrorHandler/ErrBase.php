<?php
/**
 * Обработка ошибок проекта
 * @file    ErrBase.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Пнд Июл 16 22:08:47 2012
 * @version
 */

namespace Veles\ErrorHandler;

use Exception;
use SplObserver;
use SplSubject;
use Veles\DataBase\DbException;
use Veles\View\View;

/**
 * Класс Error
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ErrBase implements SplSubject
{
	private $vars;
	private $output;
	private $observers = array();

	/**
	 * Обработчик пользовательских ошибок
	 */
	final public function usrError($type, $message, $file, $line, $defined)
	{
		$this->vars['type']    = $this->getErrorType($type);
		$this->vars['time']    = strftime('%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']);
		$this->vars['message'] = $message;
		$this->vars['file']    = str_replace(BASE_PATH, '', $file);
		$this->vars['line']    = $line;
		$this->vars['stack']   = $this->getStack(array_reverse(debug_backtrace()));
		$this->vars['defined'] = $defined;

		$this->process();
	}

	/**
	 * Обработчик php ошибок
	 */
	final public function fatal()
	{
		if (null === ($this->vars = error_get_last())) exit;

		$this->vars['type']    = $this->getErrorType($this->vars['type']);
		$this->vars['time']    = strftime('%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']);
		$this->vars['file']    = str_replace(BASE_PATH, '', $this->vars['file']);
		$this->vars['stack']   = array();
		$this->vars['defined'] = array();

		$this->process();
	}

	/**
	 * Обработчик исключений
	 * @param Exception $exception Исключение
	 */
	final public function exception($exception)
	{
		$this->vars['type']    = $this->getErrorType($exception->getCode());
		$this->vars['time']    = strftime('%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']);
		$this->vars['message'] = $exception->getMessage();
		$this->vars['file']    = str_replace(BASE_PATH, '', $exception->getFile());
		$this->vars['line']    = $exception->getLine();
		$this->vars['stack']   = $this->getStack(array_reverse($exception->getTrace()));
		$this->vars['defined'] = ($exception instanceof DbException)
			? array(
				'connect_error' => $exception->getConnectError(),
				'sql_error'     => $exception->getSqlError(),
				'sql_query'     => $exception->getSqlQuery())
			: array();

		$this->process();
	}

	/**
	 * Метод обработки исключений
	 */
	final public function process()
	{
		if ('development' === ENVIRONMENT) {
			View::set($this->vars);
			View::show('error/exception.phtml');
		} else {
			View::set($this->vars);
			$this->output = View::get('error/exception.phtml');

			//TODO: $this->attach(new ErrorSMS($this->vars));
			$this->attach(new ErrMail());
			$this->notify();

			//TODO: go to custom error page;
			exit;
		}
	}

	/**
	 * Получение типа ошибки
	 * @param string $type
	 * @return string
	 */
	private function getErrorType($type)
	{
		$err_types = array(
			E_ERROR             => 'FATAL ERROR',               // 1
			E_WARNING           => 'WARNING',                   // 2
			E_PARSE             => 'PARSE ERROR',               // 4
			E_NOTICE            => 'NOTICE',                    // 8
			E_CORE_ERROR        => 'CORE ERROR',                // 16
			E_CORE_WARNING      => 'CORE WARNING',              // 32
			E_CORE_ERROR        => 'COMPILE ERROR',             // 64
			E_CORE_WARNING      => 'COMPILE WARNING',           // 128
			E_USER_ERROR        => 'USER ERROR',                // 256
			E_USER_WARNING      => 'USER WARNING',              // 512
			E_USER_NOTICE       => 'USER NOTICE',               // 1024
			E_STRICT            => 'STRICT NOTICE',             // 2048
			E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',         // 4096
			E_DEPRECATED        => 'DEPRECATED WARNING',        // 8192
			E_USER_DEPRECATED   => 'USER DEPRECATED WARNING',   // 16384
			0                   => 'EXCEPTION'
		);

		return (isset($err_types[$type]))
			? $err_types[$type]
			: "UNKNOWN ERROR TYPE: $type";
	}

	/**
	 * Форматирование стека вызовов
	 * @param array $stack Массив вызовов
	 * @return array
	 */
	private function getStack($stack)
	{
		foreach ($stack as &$call) {
			$call['function'] = (isset($call['class']))
				? $call['class'] . $call['type'] . $call['function']
				: $call['function'];

			$call['file'] = (isset($call['file']))
				? $call['file'] . '<b>:</b>' . $call['line']
				: '';
		}

		return $stack;
	}

	/**
	 * Метод уведомления наблюдателей об ошибке
	 */
	final public function notify()
	{
		/** @var $observer SplObserver */
		foreach ($this->observers as $observer) {
			$observer->update($this);
		}
	}

	/**
	 * Метод добавления наблюдателей
	 */
	final public function attach(SplObserver $observer)
	{
		$this->observers[] = $observer;
	}

	/**
	 * Метод удаления наблюдателей
	 */
	final public function detach(SplObserver $observer)
	{
		foreach ($this->observers as $key => $subscriber) {
			if ($subscriber == $observer) {
				unset($this->observers[$key]);
				return;
			}
		}
	}

	/**
	 * Получение сообщения
	 * @return string
	 */
	final public function getMessage()
	{
		return $this->output;
	}
}