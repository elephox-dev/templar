<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\Colors;
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
				primary: Colors::Azure(),
				secondary: Colors::NeonGreen(),
				tertiary: Colors::Violet(),
				background: Colors::White(),
				foreground: Colors::Black(),
				onPrimary: Colors::White(),
				onSecondary: Colors::White(),
				onTertiary: Colors::White(),
				divider: Colors::Grayscale(0.33),
			),
			darkColorScheme: new ColorScheme(
				primary: Colors::Azure(),
				secondary: Colors::NeonGreen(),
				tertiary: Colors::Violet(),
				background: Colors::Grayscale(0.15),
				foreground: Colors::White(),
				onPrimary: Colors::White(),
				onSecondary: Colors::White(),
				onTertiary: Colors::White(),
				divider: Colors::Grayscale(0.33),
			),
		);
	}

	public function render(Widget $widget): string {
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

		return $widget->render($context);
	}

	public function renderStyle(Widget $widget): string {
		$context = $this->getDefaultRenderContext();

		$style = "* {box-sizing: border-box;}";
		$style .= $widget->renderStyle($context);

		if ($context->darkColorScheme !== null) {
			$context->renderedClasses = [];
			$darkTheme = $widget->renderStyle($context->withColorScheme($context->darkColorScheme));

			$style .= "@media (prefers-color-scheme: dark) {{$darkTheme}}";
		}

		return $style;
	}
}
