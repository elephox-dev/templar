<?php
declare(strict_types=1);

namespace Elephox\Templar;

class ColorScheme {
	public function __construct(
		public readonly Color $primary,
		public readonly Color $secondary,
		public readonly Color $tertiary,
		public readonly Color $background,
		public readonly Color $foreground,
		public readonly Color $onPrimary,
		public readonly Color $onSecondary,
		public readonly Color $onTertiary,
		public readonly Color $divider,
	) {}

	public function with(
		?Color $primary = null,
		?Color $secondary = null,
		?Color $tertiary = null,
		?Color $background = null,
		?Color $foreground = null,
		?Color $onPrimary = null,
		?Color $onSecondary = null,
		?Color $onTertiary = null,
		?Color $divider = null,
	): ColorScheme {
		return new ColorScheme(
			primary: $primary ?? $this->primary,
			secondary: $secondary ?? $this->secondary,
			tertiary: $tertiary ?? $this->tertiary,
			background: $background ?? $this->background,
			foreground: $foreground ?? $this->foreground,
			onPrimary: $onPrimary ?? $this->onPrimary,
			onSecondary: $onSecondary ?? $this->onSecondary,
			onTertiary: $onTertiary ?? $this->onTertiary,
			divider: $divider ?? $this->divider,
		);
	}
}
