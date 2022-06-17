<?php
declare(strict_types=1);

namespace Elephox\Templar;

use JetBrains\PhpStorm\ArrayShape;
use Stringable;

class Color implements Stringable, Hashable {
	public static function fromRGBA(int $red, int $green, int $blue, int $alpha): Color {
		assert(
			$red >= 0 && $red <= 0xFF,
			'Red must be between 0 and 0xFF',
		);
		assert(
			$green >= 0 && $green <= 0xFF,
			'Green must be between 0 and 0xFF',
		);
		assert(
			$blue >= 0 && $blue <= 0xFF,
			'Blue must be between 0 and 0xFF',
		);
		assert(
			$alpha >= 0 && $alpha <= 0xFF,
			'Alpha must be between 0 and 0xFF',
		);

		$value = $red << 24 | $green << 16 | $blue << 8 | $alpha;

		return new Color($value);
	}

	public function mix(int|Color $other, float $t): Color {
		return self::lerp($this, $other, $t);
	}

	public static function lerp(int|Color $a, int|Color $b, float $t): Color {
		assert(
			$t >= 0 && $t <= 1,
			'$t must be between 0 and 1',
		);

		if (is_int($a)) {
			$a = new Color($a);
		}

		if (is_int($b)) {
			$b = new Color($b);
		}

		$aRGBA = $a->toArray();
		$bRGBA = $b->toArray();

		$red = (int)round((1 - $t) * $aRGBA['red'] + $t * $bRGBA['red']);
		$green = (int)round((1 - $t) * $aRGBA['green'] + $t * $bRGBA['green']);
		$blue = (int)round((1 - $t) * $aRGBA['blue'] + $t * $bRGBA['blue']);
		$alpha = (int)round((1 - $t) * $aRGBA['alpha'] + $t * $bRGBA['alpha']);

		return new Color($red << 24 | $green << 16 | $blue << 8 | $alpha);
	}

	public function __construct(
		private readonly int $value,
	) {
		assert(
			$value >= 0 && $value <= 0xFFFFFFFF,
			'Color value must be between 0x0 and 0xFFFFFFFF',
		);
	}

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

	#[ArrayShape(['red' => "int", 'green' => "int", 'blue' => "int", 'alpha' => "int"])]
	public function toArray(): array {
		return [
			'red' => ($this->value >> 24) & 0xFF,
			'green' => ($this->value >> 16) & 0xFF,
			'blue' => ($this->value >> 8) & 0xFF,
			'alpha' => $this->value & 0xFF,
		];
	}

	public function withOpacity(float $opacity): Color {
		assert(
			$opacity >= 0 && $opacity <= 1,
			'Opacity must be between 0 and 1',
		);

		$alpha = (int)round($opacity * 0xFF);

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

	public function getHashCode(): int {
		return $this->value;
	}
}
