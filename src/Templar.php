<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\Colors;
use ErrorException;

class Templar {
	public static function getDefaultRenderContext(
		?ColorScheme $lightColorScheme = null,
		?ColorScheme $darkColorScheme = null,
	): RenderContext {
		$lightColorScheme = self::getDefaultColorScheme()->overwriteFrom($lightColorScheme);
		$darkColorScheme =
			self::getDefaultDarkColorScheme($lightColorScheme)->overwriteFrom($darkColorScheme);

		return new RenderContext(
			meta: new DocumentMeta(),
			colorScheme: $lightColorScheme,
			darkColorScheme: $darkColorScheme,
			textStyle: new TextStyle(
				font: 'sans-serif',
				size: Length::inRem(1),
			),
		);
	}

	public static function getDefaultColorScheme(): ColorScheme {
		return new ColorScheme(
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
	}

	public static function getDefaultDarkColorScheme(?ColorScheme $lightColorScheme = null
	): ColorScheme {
		$light = self::getDefaultColorScheme()->overwriteFrom($lightColorScheme);

		return $light->with(
			primary: $light->primary->darken(0.1)->desaturate(0.3),
			secondary: $light->secondary->darken(0.1)->desaturate(0.3),
			tertiary: $light->tertiary->darken(0.1)->desaturate(0.3),
			background: Colors::Grayscale(0.15),
			foreground: Colors::Grayscale(0.85),
			onPrimary: Colors::Grayscale(0.95),
		);
	}

	protected readonly RenderContext $context;

	public function __construct(
		?DocumentMeta $meta = null,
		?ColorScheme $colorScheme = null,
		?ColorScheme $darkColorScheme = null,
		?TextStyle $textStyle = null,
		?PositionContext $positionContext = null,
	) {
		$default = self::getDefaultRenderContext($colorScheme, $darkColorScheme);

		$this->context = $default->with(
			meta: $meta,
			textStyle: $default->textStyle->overwriteFrom($textStyle),
			positionContext: $positionContext,
		);
	}

	public function render(Widget $widget): string {
		$context = $this->context;

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
		$context = $this->context;

		$style = "* {box-sizing: border-box;}";
		$style .= $widget->renderStyle($context);

		if ($context->darkColorScheme !== null) {
			$context->renderedClasses = [];
			$darkTheme = $widget->renderStyle($context->withColorScheme($context->darkColorScheme));

			$style .= "@media (prefers-color-scheme: dark) {" . $darkTheme . "}";
		}

		return $style;
	}
}
