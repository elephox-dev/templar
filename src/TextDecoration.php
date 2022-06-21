<?php
declare(strict_types=1);

namespace Elephox\Templar;

class TextDecoration implements Emittable {
	public static function none(): TextDecoration {
		return new TextDecoration([TextDecorationPosition::None]);
	}

	public function __construct(
		protected readonly ?array $positions = null,
		protected readonly ?Color $color = null,
		protected readonly ?TextDecorationStyle $style = null,
		protected readonly ?Length $thickness = null,
	) {
		if ($this->positions !== null) {
			$containsNone = false;
			foreach ($this->positions as $position) {
				assert(
					$position instanceof TextDecorationPosition,
					"TextDecorationPosition must be an instance of TextDecorationPosition, but '" .
					get_debug_type($position) . "' was given"
				);

				$containsNone = $containsNone || $position === TextDecorationPosition::None;
			}

			assert(
				count($this->positions) === 1 || !$containsNone,
				"Cannot combine 'none' with other text decoration positions"
			);
		}
	}

	public function __toString(): string {
		$str = "";

		if ($this->positions !== null) {
			foreach ($this->positions as $position) {
				$str .= $position->value . " ";
			}
			$str = rtrim($str);
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
		?array $positions = null,
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
		?array $positions = null,
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