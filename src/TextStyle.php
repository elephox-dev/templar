<?php
declare(strict_types=1);

namespace Elephox\Templar;

class TextStyle implements Hashable {
	public static function bold(): self {
		return new TextStyle(weight: "bold");
	}

	public static function italic(): self {
		return new TextStyle(fontStyle: FontStyle::Italic);
	}

	public function __construct(
		public ?string $font = null,
		public ?Length $size = null,
		public ?Length $lineHeight = null,
		public null|string|int $weight = null,
		public ?TextAlign $align = null,
		public ?Color $color = null,
		public ?Color $background = null,
		public ?TextDecoration $decoration = null,
		public ?FontStyle $fontStyle = null,
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

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->font,
			$this->size,
			$this->lineHeight,
			$this->weight,
			$this->align,
			$this->color,
			$this->background,
			$this->decoration,
			$this->fontStyle,
		);
	}

	public function overwriteFrom(?TextStyle $other): TextStyle {
		if ($other === null) {
			return $this;
		}

		return new TextStyle(
			$other->font ?? $this->font,
			$other->size ?? $this->size,
			$other->lineHeight ?? $this->lineHeight,
			$other->weight ?? $this->weight,
			$other->align ?? $this->align,
			$other->color ?? $this->color,
			$other->background ?? $this->background,
			$other->decoration ?? $this->decoration,
			$other->fontStyle ?? $this->fontStyle,
		);
	}

	public function withFallback(
		?string $font = null,
		?Length $size = null,
		?Length $lineHeight = null,
		null|string|int $weight = null,
		?TextAlign $align = null,
		?Color $color = null,
		?Color $background = null,
		?TextDecoration $decoration = null,
		?FontStyle $fontStyle = null,
	): TextStyle {
		return new TextStyle(
			$this->font ?? $font,
			$this->size ?? $size,
			$this->lineHeight ?? $lineHeight,
			$this->weight ?? $weight,
			$this->align ?? $align,
			$this->color ?? $color,
			$this->background ?? $background,
			$this->decoration ?? $decoration,
			$this->fontStyle ?? $fontStyle,
		);
	}

	public function with(
		?string $font = null,
		?Length $size = null,
		?Length $lineHeight = null,
		null|string|int $weight = null,
		?TextAlign $align = null,
		?Color $color = null,
		?Color $background = null,
		?TextDecoration $decoration = null,
		?FontStyle $fontStyle = null,
	): TextStyle {
		return new TextStyle(
			$font ?? $this->font,
			$size ?? $this->size,
			$lineHeight ?? $this->lineHeight,
			$weight ?? $this->weight,
			$align ?? $this->align,
			$color ?? $this->color,
			$background ?? $this->background,
			$decoration ?? $this->decoration,
			$fontStyle ?? $this->fontStyle,
		);
	}
}
