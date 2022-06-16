<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

class Color implements Stringable {
	public static function fromHex(string $hex): Color {
		if (str_starts_with(
			$hex,
			'#',
		)) {
			$hex =
				substr(
					$hex,
					1,
				);
		}

		assert(
			strlen($hex) === 8,
			'Hex color must be 8 characters long',
		);

		$r =
			hexdec(
				substr(
					$hex,
					0,
					2,
				)
			);
		$g =
			hexdec(
				substr(
					$hex,
					2,
					2,
				)
			);
		$b =
			hexdec(
				substr(
					$hex,
					4,
					2,
				)
			);
		$a =
			hexdec(
				substr(
					$hex,
					6,
					2,
				)
			);

		return self::fromRGBA(
			$r,
			$g,
			$b,
			$a,
		);
	}

	public static function fromRGBA(int $red, int $green, int $blue, int $alpha): Color {
		assert(
			$red >= 0 && $red <= 255,
			'Red must be between 0 and 255',
		);
		assert(
			$green >= 0 && $green <= 255,
			'Green must be between 0 and 255',
		);
		assert(
			$blue >= 0 && $blue <= 255,
			'Blue must be between 0 and 255',
		);
		assert(
			$alpha >= 0 && $alpha <= 255,
			'Alpha must be between 0 and 255',
		);

		$value = $red << 24 | $green << 16 | $blue << 8 | $alpha;

		return new Color($value);
	}

	public function __construct(
		private readonly int $value,
	) {}

	public function toHex(): string {
		return sprintf(
			'#%08X',
			$this->value,
		);
	}

	public function toRGBA(): string {
		return sprintf(
			'rgba(%d, %d, %d, %d)',
			($this->value >> 24) & 0xFF,
			($this->value >> 16) & 0xFF,
			($this->value >> 8) & 0xFF,
			$this->value & 0xFF,
		);
	}

	public function withOpacity(float $opacity): Color {
		assert(
			$opacity >= 0 && $opacity <= 1,
			'Opacity must be between 0 and 1',
		);

		$alpha = (int) round($opacity * 255);

		return self::fromRGBA(
			($this->value >> 24) & 0xFF,
			($this->value >> 16) & 0xFF,
			($this->value >> 8) & 0xFF,
			$alpha,
		);
	}

	public function __toString(): string {
		return $this->toHex();
	}
}
