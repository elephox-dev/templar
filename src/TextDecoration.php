<?php
declare(strict_types=1);

namespace Elephox\Templar;

readonly class TextDecoration implements Emittable {
	public static function none(): TextDecoration {
		return new TextDecoration([TextDecorationPosition::None]);
	}

	public static function underline(
		?Color $color = null,
		?TextDecorationStyle $style = null,
		null|Length|int|float $thickness = null
	): TextDecoration {
		return new TextDecoration(
			[TextDecorationPosition::Underline],
			$color,
			$style,
			$thickness
		);
	}

	protected ?Length $thickness;

	public function __construct(
		protected ?iterable $positions = null,
		protected ?Color $color = null,
		protected ?TextDecorationStyle $style = null,
		null|Length|int|float $thickness = null,
	) {
		if ($this->positions !== null) {
			$containsNone = false;
			$count = 0;
			foreach ($this->positions as $position) {
				assert(
					$position instanceof TextDecorationPosition,
					"\$positions items must be instances of TextDecorationPosition, but '" .
					get_debug_type($position) .
					"' was given"
				);

				$containsNone = $containsNone || $position === TextDecorationPosition::None;
				$count++;
			}

			assert(
				$count === 1 || !$containsNone,
				"Cannot combine 'none' with other text decoration positions"
			);
		}

		$this->thickness = $thickness !== null ? Length::wrap($thickness) : null;
	}

	public function __toString(): string {
		$str = "";

		if ($this->positions !== null) {
			foreach ($this->positions as $position) {
				$str .= " " . $position->value;
			}
		}

		if ($this->color !== null) {
			$str .= " $this->color";
		}

		if ($this->style !== null) {
			$str .= " $this->style";
		}

		if ($this->thickness !== null) {
			$str .= " $this->thickness";
		}

		return ltrim($str);
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->positions,
			$this->color,
			$this->style,
			$this->thickness,
		);
	}

	public function toEmittable(): string {
		return "text-decoration: $this;";
	}

	public function withFallback(
		?iterable $positions = null,
		?Color $color = null,
		?TextDecorationStyle $style = null,
		?Length $thickness = null,
	): TextDecoration {
		return new TextDecoration(
			$this->positions ?? $positions,
			$this->color ?? $color,
			$this->style ?? $style,
			$this->thickness ?? $thickness,
		);
	}

	public function with(
		?iterable $positions = null,
		?Color $color = null,
		?TextDecorationStyle $style = null,
		?Length $thickness = null,
	): TextDecoration {
		return new TextDecoration(
			$positions ?? $this->positions,
			$color ?? $this->color,
			$style ?? $this->style,
			$thickness ?? $this->thickness,
		);
	}
}