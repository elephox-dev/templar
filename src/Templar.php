<?php
declare(strict_types=1);

namespace Elephox\Templar;

use ErrorException;

class Templar {
	public static function combineHashCodes(null|int|Hashable ...$hashCodes): int {
		$hash = 0;
		foreach ($hashCodes as $hashCode) {
			if ($hashCode instanceof Hashable) {
				$hashCode = $hashCode->getHashCode();
			}

			$hash = (int)($hash * 31 + ($hashCode ?? 0));
		}

		return $hash;
	}

	protected function getDefaultRenderContext(): RenderContext {
		return new RenderContext(
			colorScheme: new ColorScheme(
				primary: new Color(0x0097ffff),
				secondary: new Color(0x00ff51ff),
				tertiary: new Color(0xaa00ffff),
				background: new Color(0xffffffff),
				foreground: new Color(0x000000ff),
				onPrimary: new Color(0xffffffff),
				onSecondary: new Color(0xffffffff),
				onTertiary: new Color(0xffffffff),
				divider: new Color(0x888888ff),
			),
			darkColorScheme: new ColorScheme(
				primary: new Color(0x0097ffff),
				secondary: new Color(0x00ff51ff),
				tertiary: new Color(0xaa00ffff),
				background: new Color(0x444444ff),
				foreground: new Color(0xffffffff),
				onPrimary: new Color(0xffffffff),
				onSecondary: new Color(0xffffffff),
				onTertiary: new Color(0xffffffff),
				divider: new Color(0xccccccff),
			),
		);
	}

	public function render(Widget $widget): void {
		header('Content-Type: text/html');

		$context = $this->getDefaultRenderContext();

		set_error_handler(
			static function (
				int $errno,
				string $errstr,
				?string $errfile = null,
				?int $errline = null
			): never {
				/** @noinspection PhpUnhandledExceptionInspection */
				throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
			}
		);

		echo $widget->render($context);
	}

	public function renderStyle(Widget $widget): void {
		header('Content-Type: text/css');

		$context = $this->getDefaultRenderContext();

		echo <<<CSS
* {
  box-sizing: border-box;
}
CSS;

		echo $widget->renderStyle($context);
	}
}
