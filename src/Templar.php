<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Templar {
	public function render(Widget $widget): void {
		$context = new RenderContext(
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
			textStyle: new TextStyle(
				"sans-serif",
				Length::inRem(1),
				400,
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

		echo $widget->render($context);
	}
}
