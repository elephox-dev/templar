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
				font: '"SF Pro", "Segoe UI", "Fira Sans", sans-serif',
				size: Length::inRem(1),
			),
		);
	}

	public static function getDefaultColorScheme(): ColorScheme {
		$primary = Colors::SkyBlue();
		$secondary = Colors::Emerald();
		$tertiary = Colors::Grayscale(0.6);

		return new ColorScheme(
			primary: $primary,
			secondary: $secondary,
			tertiary: $tertiary,
			background: Colors::White(),
			foreground: Colors::Black(),
			divider: Colors::Grayscale(0.33),
		);
	}

	public static function getDefaultDarkColorScheme(
		?ColorScheme $lightColorScheme = null,
	): ColorScheme {
		$light = self::getDefaultColorScheme()->overwriteFrom($lightColorScheme);
		$primary = $light->primary->darken(0.1)->desaturate(0.2);
		$secondary = $light->secondary->darken(0.1)->desaturate(0.2);
		$tertiary = $light->tertiary->darken(0.1)->desaturate(0.2);

		return $light->with(
			primary: $primary,
			secondary: $secondary,
			tertiary: $tertiary,
			background: Colors::Grayscale(0.15),
			foreground: Colors::Grayscale(0.85),
		);
	}

	protected readonly RenderContext $context;

	public function __construct(
		?DocumentMeta $meta = null,
		?ColorScheme $colorScheme = null,
		?ColorScheme $darkColorScheme = null,
		?TextStyle $textStyle = null,
		?PositionContext $positionContext = null,
		bool $checkColorContrast = true,
	) {
		$default = self::getDefaultRenderContext($colorScheme, $darkColorScheme);

		$this->context = $default->with(
			meta: $meta,
			colorScheme: $default->colorScheme->withFallback(
				onPrimary: $default->colorScheme->primary->bestEffortContrast(),
				onSecondary: $default->colorScheme->secondary->bestEffortContrast(),
				onTertiary: $default->colorScheme->tertiary->bestEffortContrast(),
			),
			darkColorScheme: $default->darkColorScheme->withFallback(
				onPrimary: $default->darkColorScheme->primary->bestEffortContrast(),
				onSecondary: $default->darkColorScheme->secondary->bestEffortContrast(),
				onTertiary: $default->darkColorScheme->tertiary->bestEffortContrast(),
			),
			textStyle: $default->textStyle->overwriteFrom($textStyle),
			positionContext: $positionContext,
		);

		if ($checkColorContrast) {
			set_error_handler(
				function (int $errno, string $errstr) {
					$err =
						fopen(
							'php://stderr',
							'wb'
						);
					fwrite(
						$err,
						"Please check your color scheme contrasts!\r\nGot this error while checking light theme:\r\n$errstr\r\n"
					);
					fclose($err);
				}
			);

			$this->context->colorScheme->checkContrasts();

			restore_error_handler();
			set_error_handler(
				function (int $errno, string $errstr) {
					$err =
						fopen(
							'php://stderr',
							'wb'
						);
					fwrite(
						$err,
						"Please check your color scheme contrasts!\r\nGot this error while checking dark theme:\r\n$errstr\r\n"
					);
					fclose($err);
				}
			);

			$this->context->darkColorScheme->checkContrasts();

			restore_error_handler();
		}
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
