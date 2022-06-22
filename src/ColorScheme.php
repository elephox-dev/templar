<?php
declare(strict_types=1);

namespace Elephox\Templar;

class ColorScheme {
	public function __construct(
		public readonly ?Color $primary = null,
		public readonly ?Color $secondary = null,
		public readonly ?Color $tertiary = null,
		public readonly ?Color $background = null,
		public readonly ?Color $foreground = null,
		public readonly ?Color $onPrimary = null,
		public readonly ?Color $onSecondary = null,
		public readonly ?Color $onTertiary = null,
		public readonly ?Color $divider = null,
	) {}

	public function checkContrasts(): void {
		if ($this->primary !== null && $this->onPrimary !== null &&
			$this->primary->contrastRatio($this->onPrimary) < Color::MinContrastRatioAA
		) {
			trigger_error(
				'Primary color contrast ratio is too low: ' .
				$this->primary->contrastRatio($this->onPrimary) .
				' (' . $this->primary->toHex() . ' / ' . $this->onPrimary->toHex() . ')'
			);
		}
		if ($this->secondary !== null && $this->onSecondary !== null &&
			$this->secondary->contrastRatio($this->onSecondary) < Color::MinContrastRatioAA
		) {
			trigger_error(
				'Secondary color contrast ratio is too low: ' .
				$this->secondary->contrastRatio($this->onSecondary) .
				' (' . $this->secondary->toHex() . ' / ' . $this->onSecondary->toHex() . ')'
			);
		}
		if (
			$this->tertiary !== null && $this->onTertiary !== null &&
			$this->tertiary->contrastRatio($this->onTertiary) < Color::MinContrastRatioAA
		) {
			trigger_error(
				'Tertiary color contrast ratio is too low: ' .
				$this->tertiary->contrastRatio($this->onTertiary) .
				' (' . $this->tertiary->toHex() . ' / ' . $this->onTertiary->toHex() . ')'
			);
		}
	}

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

	public function overwriteFrom(?ColorScheme $scheme): ColorScheme {
		if ($scheme === null || $scheme === $this) {
			return $this;
		}

		return $this->with(
			primary: $scheme->primary,
			secondary: $scheme->secondary,
			tertiary: $scheme->tertiary,
			background: $scheme->background,
			foreground: $scheme->foreground,
			onPrimary: $scheme->onPrimary,
			onSecondary: $scheme->onSecondary,
			onTertiary: $scheme->onTertiary,
			divider: $scheme->divider,
		);
	}

	public function withFallback(
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
			primary: $this->primary ?? $primary,
			secondary: $this->secondary ?? $secondary,
			tertiary: $this->tertiary ?? $tertiary,
			background: $this->background ?? $background,
			foreground: $this->foreground ?? $foreground,
			onPrimary: $this->onPrimary ?? $onPrimary,
			onSecondary: $this->onSecondary ?? $onSecondary,
			onTertiary: $this->onTertiary ?? $onTertiary,
			divider: $this->divider ?? $divider,
		);
	}
}
