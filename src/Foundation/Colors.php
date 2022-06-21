<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;

abstract class Colors {
	public static function Blue(): Color {
		return new Color(0x0000FFFF);
	}

	public static function Cyan(): Color {
		return new Color(0x00FFFFFF);
	}

	public static function Green(): Color {
		return new Color(0x00FF00FF);
	}

	public static function Magenta(): Color {
		return new Color(0xFF00FFFF);
	}

	public static function Red(): Color {
		return new Color(0xFF0000FF);
	}

	public static function Yellow(): Color {
		return new Color(0xFFFF00FF);
	}

	public static function Grayscale(float $lightness): Color {
		assert($lightness >= 0.0 && $lightness <= 1.0, 'Scale must be between 0.0 and 1.0');

		return Color::fromHSLA(0.0, 0.0, $lightness * 100.0, 1.0);
	}

	public static function Black(): Color {
		return self::Grayscale(0.0);
	}

	public static function DarkGray(): Color {
		return self::Grayscale(0.25);
	}

	public static function Gray(): Color {
		return self::Grayscale(0.5);
	}

	public static function LightGray(): Color {
		return self::Grayscale(0.75);
	}

	public static function White(): Color {
		return self::Grayscale(1.0);
	}

	public static function Transparent(): Color {
		return new Color(0x00000000);
	}

	public static function SkyBlue(): Color {
		return self::Blue()->mix(self::Cyan(), 0.75);
	}

	public static function HotPink(): Color {
		return self::Red()->mix(self::Magenta(), 0.5);
	}

	public static function Violet(): Color {
		return new Color(0xAA00FFFF);
	}

	public static function NeonGreen(): Color {
		return new Color(0x39FF14FF);
	}

	public static function Azure(): Color {
		return new Color(0x3399FFFF);
	}

	public static function Emerald(): Color {
		return new Color(0x04BC56FF);
	}
}
