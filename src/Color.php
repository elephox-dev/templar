<?php
declare(strict_types=1);

namespace Elephox\Templar;

use JetBrains\PhpStorm\ArrayShape;
use Stringable;

class Color implements Stringable, Hashable {
	public static function calculateHue(
		float $max,
		float $min,
		float|int $r,
		float|int $g,
		float|int $b,
		float $hStart,
	): float {
		$h = $hStart;
		$d = $max - $min;
		switch ($max) {
			case $r:
				$h = ($g - $b) / $d + ($g < $b ? 6 : 0);
				break;
			case $g:
				$h = ($b - $r) / $d + 2;
				break;
			case $b:
				$h = ($r - $g) / $d + 4;
				break;
		}
		$h /= 6;
		return $h;
	}

	public static function fromRGBA(int $red, int $green, int $blue, int $alpha): Color {
		assert(
			$red >= 0 && $red <= 0xFF,
			'Red must be between 0 and 255, got ' . $red,
		);
		assert(
			$green >= 0 && $green <= 0xFF,
			'Green must be between 0 and 255, got ' . $green,
		);
		assert(
			$blue >= 0 && $blue <= 0xFF,
			'Blue must be between 0 and 255, got ' . $blue,
		);
		assert(
			$alpha >= 0 && $alpha <= 0xFF,
			'Alpha must be between 0 and 255, got ' . $alpha,
		);

		$value = $red << 24 | $green << 16 | $blue << 8 | $alpha;

		return new Color($value);
	}

	public static function fromHSLA(
		float $hue,
		float $saturation,
		float $lightness,
		float $alpha
	): Color {
		assert(
			$hue >= 0.0 && $hue <= 360.0,
			'Hue must be between 0 and 360, got ' . $hue,
		);

		assert(
			$saturation >= 0.0 && $saturation <= 100.0,
			'Saturation must be between 0 and 100, got ' . $saturation,
		);

		assert(
			$lightness >= 0.0 && $lightness <= 100.0,
			'Lightness must be between 0 and 100, got ' . $lightness,
		);

		assert(
			$alpha >= 0.0 && $alpha <= 1.0,
			'Alpha must be between 0 and 1, got ' . $alpha,
		);

		$hue /= 360.0;
		$lightness /= 100.0;
		$saturation /= 100.0;

		$m2 = $lightness <= 0.5
			? $lightness * ($saturation + 1.0) : $lightness + $saturation -
			$lightness * $saturation;
		$m1 = $lightness * 2.0 - $m2;

		$h2rgb = static function (float $t) use ($m1, $m2): float {
			$t = $t < 0.0 ? $t + 1.0 : ($t > 1.0 ? $t - 1.0 : $t);
			if ($t * 6.0 < 1.0) {
				return $m1 + ($m2 - $m1) * 6.0 * $t;
			}

			if ($t * 2.0 < 1.0) {
				return $m2;
			}

			if ($t * 3.0 < 2.0) {
				return $m1 + ($m2 - $m1) * (2.0 / 3.0 - $t) * 6.0;
			}

			return $m1;
		};

		$red = (int)round($h2rgb($hue + 1.0 / 3.0) * 255.0);
		$green = (int)round($h2rgb($hue) * 255.0);
		$blue = (int)round($h2rgb($hue - 1.0 / 3.0) * 255.0);
		$alpha = (int)round($alpha * 255.0);

		return self::fromRGBA($red, $green, $blue, $alpha);
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

		$aRGBA = $a->toRgbArray();
		$bRGBA = $b->toRgbArray();

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

	#[ArrayShape([
		'red' => "int",
		'green' => "int",
		'blue' => "int",
		'alpha' => "int"
	])]
	public function toRgbArray(): array {
		return [
			'red' => ($this->value >> 24) & 0xFF,
			'green' => ($this->value >> 16) & 0xFF,
			'blue' => ($this->value >> 8) & 0xFF,
			'alpha' => $this->value & 0xFF,
		];
	}

	#[ArrayShape([
		'red' => "float",
		'green' => "float",
		'blue' => "float",
		'alpha' => "float"
	])] public function getNormalizedRgb(): array {
		$rgb = $this->toRgbArray();
		$rgb['red'] /= 255;
		$rgb['green'] /= 255;
		$rgb['blue'] /= 255;
		$rgb['alpha'] /= 255;
		return $rgb;
	}

	#[ArrayShape([
		'hue' => "float",
		'saturation' => "float",
		'lightness' => "float",
		'alpha' => "float"
	])]
	public function toHslArray(): array {
		[$red, $green, $blue, $alpha] = array_values($this->getNormalizedRgb());
		$max = max($red, $green, $blue);
		$min = min($red, $green, $blue);

		$h = $l = ($max + $min) / 2;

		if ($max === $min) {
			$h = $s = 0; // achromatic
		} else {
			$d = $max - $min;
			$s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
			$h = self::calculateHue($max, $min, $red, $green, $blue, $h);
		}
		return [
			'hue' => $h * 360,
			'saturation' => $s * 100,
			'lightness' => $l * 100,
			'alpha' => $alpha,
		];
	}

	#[ArrayShape([
		'hue' => "float",
		'saturation' => "float",
		'value' => "float",
		'alpha' => "float"
	])]
	public function toHsvArray(): array {
		[$red, $green, $blue, $alpha] = $this->getNormalizedRgb();
		$max = max($red, $green, $blue);
		$min = min($red, $green, $blue);

		$h = $v = $max;
		$d = $max - $min;
		$s = $max === 0 ? 0 : $d / $max;

		if ($max === $min) {
			$h = 0; // achromatic
		} else {
			$h = self::calculateHue($max, $min, $red, $green, $blue, $h);
		}

		return [
			'hue' => $h * 360,
			'saturation' => $s * 100,
			'value' => $v * 100,
			'alpha' => $alpha,
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

	public function with(
		?int $red = null,
		?int $green = null,
		?int $blue = null,
		?int $alpha = null
	): Color {
		$red = $red ?? ($this->value >> 24) & 0xFF;
		$green = $green ?? ($this->value >> 16) & 0xFF;
		$blue = $blue ?? ($this->value >> 8) & 0xFF;
		$alpha = $alpha ?? $this->value & 0xFF;

		return self::fromRGBA(
			$red,
			$green,
			$blue,
			$alpha
		);
	}

	public function __toString(): string {
		return $this->toHex();
	}

	public function getHashCode(): float {
		return $this->value;
	}

	public function brightness(): float {
		// https://www.w3.org/TR/AERT/#color-contrast
		return (
				($this->value >> 24) & 0xFF * 299 +
				($this->value >> 16) & 0xFF * 587 +
				($this->value >> 8) & 0xFF * 114
			) / 1000;
	}

	public function luminance(): float {
		$rs = ($this->value >> 24) & 0xFF / 255;
		$gs = ($this->value >> 16) & 0xFF / 255;
		$bs = ($this->value >> 8) & 0xFF / 255;

		if ($rs <= 0.03928) {
			$rs /= 12.92;
		} else {
			$rs = (($rs + 0.055) / 1.055) ** 2.4;
		}

		if ($gs <= 0.03928) {
			$gs /= 12.92;
		} else {
			$gs = (($gs + 0.055) / 1.055) ** 2.4;
		}

		if ($bs <= 0.03928) {
			$bs /= 12.92;
		} else {
			$bs = (($bs + 0.055) / 1.055) ** 2.4;
		}

		return 0.2126 * $rs + 0.7152 * $gs + 0.0722 * $bs;
	}

	public function desaturate(float $amount): Color {
		assert(
			$amount >= 0.0 && $amount <= 1.0,
			'Amount must be between 0 and 1',
		);

		$hsl = $this->toHslArray();
		$hsl['saturation'] *= 1 - $amount;

		return self::fromHSLA($hsl['hue'], $hsl['saturation'], $hsl['lightness'], $hsl['alpha']);
	}

	public function saturate(float $amount): Color {
		assert(
			$amount >= 0.0 && $amount <= 1.0,
			'Amount must be between 0 and 1',
		);

		$hsl = $this->toHslArray();
		$hsl['saturation'] *= 1 + $amount;

		return self::fromHSLA($hsl['hue'], $hsl['saturation'], $hsl['lightness'], $hsl['alpha']);
	}

	public function darken(float $amount): Color {
		assert(
			$amount >= 0.0 && $amount <= 1.0,
			'Amount must be between 0 and 1',
		);

		$hsl = $this->toHslArray();
		$hsl['lightness'] *= 1 - $amount;

		return self::fromHSLA($hsl['hue'], $hsl['saturation'], $hsl['lightness'], $hsl['alpha']);
	}

	public function lighten(float $amount): Color {
		assert(
			$amount >= 0.0 && $amount <= 1.0,
			'Amount must be between 0 and 1',
		);

		$hsl = $this->toHslArray();
		$hsl['lightness'] *= 1 + $amount;

		return self::fromHSLA($hsl['hue'], $hsl['saturation'], $hsl['lightness'], $hsl['alpha']);
	}
}
