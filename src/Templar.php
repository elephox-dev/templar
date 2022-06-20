<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\Colors;
use ErrorException;

class Templar {
	public static function getDefaultRenderContext(): RenderContext {
		$colors = new ColorScheme(
			primary: Colors::SkyBlue(),
			secondary: Colors::NeonGreen(),
			tertiary: Colors::Violet(),
			background: Colors::White(),
			foreground: Colors::Black(),
			onPrimary: Colors::White(),
			onSecondary: Colors::White(),
			onTertiary: Colors::White(),
			divider: Colors::Grayscale(0.33),
		);

		return new RenderContext(
			colorScheme: $colors,
			darkColorScheme: $colors->with(
				primary: $colors->primary->darken(0.1)->desaturate(0.3),
				background: Colors::Grayscale(0.15),
				foreground: Colors::Grayscale(0.85),
				onPrimary: Colors::Grayscale(0.95),
			),
		);
	}

	public function render(Widget $widget): string {
		$context = self::getDefaultRenderContext();

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
