<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;

class Colors {
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

	public static function Black(): Color {
		return new Color(0x000000FF);
	}

	public static function DarkGray(): Color {
		return new Color(0x444444FF);
	}

	public static function Gray(): Color {
		return new Color(0x888888FF);
	}

	public static function LightGray(): Color {
		return new Color(0xCCCCCCFF);
	}

	public static function White(): Color {
		return new Color(0xFFFFFFFF);
	}

	public static function Transparent(): Color {
		return new Color(0x00000000);
	}

	public static function SkyBlue(): Color {
		return new Color(0x00CCFFFF);
	}

	public static function NeonPink(): Color {
		return new Color(0xFF0066FF);
	}
}