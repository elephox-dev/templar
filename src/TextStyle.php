<?php
declare(strict_types=1);

namespace Elephox\Templar;

class TextStyle {
	public function __construct(
		public ?string $font = null,
		public ?Length $size = null,
		public null|string|int $weight = null,
		public ?TextAlign $align = null,
		public ?Color $color = null,
		public ?TextDecoration $decoration = null,
	) {
		assert(
			$this->weight === null || is_string($this->weight) || $this->weight % 100 === 0,
			"Weight must be a multiple of 100, but $this->weight was given"
		);
		assert(
			$this->weight === null || is_string($this->weight) ||
			($this->weight >= 100 && $this->weight <= 900),
			"Weight must be between 100 and 900 (inclusive), but $this->weight was given"
		);
		assert(
			$this->weight === null || is_int($this->weight) ||
			in_array(strtolower($this->weight), ['normal', 'bold', 'lighter', 'bolder'], true),
			"Weight must be one of 'normal', 'bold', 'lighter', 'bolder', but '$this->weight' was given"
		);
	}

	public function overwriteFrom(?TextStyle $other): TextStyle {
		if ($other === null) {
			return $this;
		}

		return new TextStyle(
			$other->font ?? $this->font,
			$other->size ?? $this->size,
			$other->weight ?? $this->weight,
			$other->align ?? $this->align,
			$other->color ?? $this->color,
			$other->decoration ?? $this->decoration,
		);
	}

	public function withFallback(
		?string $font = null,
		?Length $size = null,
		null|string|int $weight = null,
		?TextAlign $align = null,
		?Color $color = null,
		?TextDecoration $decoration = null,
	): TextStyle {
		return new TextStyle(
			$this->font ?? $font,
			$this->size ?? $size,
			$this->weight ?? $weight,
			$this->align ?? $align,
			$this->color ?? $color,
			$this->decoration ?? $decoration,
		);
	}

	public function with(
		?string $font = null,
		?Length $size = null,
		null|string|int $weight = null,
		?TextAlign $align = null,
		?Color $color = null,
		?TextDecoration $decoration = null,
	): TextStyle {
		return new TextStyle(
			$font ?? $this->font,
			$size ?? $this->size,
			$weight ?? $this->weight,
			$align ?? $this->align,
			$color ?? $this->color,
			$decoration ?? $this->decoration,
		);
	}
}
