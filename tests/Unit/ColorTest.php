<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Color;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\Color
 */
class ColorTest extends TestCase {
	public function hslConversionValuesProvider(): iterable {
		yield [
			[0, 0, 0, 0],
			[0, 0, 0, 0],
		];

		yield [
			[255, 255, 255, 255],
			[0, 0, 100, 1.0],
		];

		yield [
			[255, 0, 0, 255],
			[0, 100, 50, 1.0],
		];

		yield [
			[0, 255, 0, 255],
			[120, 100, 50, 1.0],
		];

		yield [
			[0, 0, 255, 255],
			[240, 100, 50, 1.0],
		];

		yield [
			[255, 255, 0, 255],
			[60, 100, 50, 1.0],
		];

		yield [
			[255, 0, 255, 255],
			[300, 100, 50, 1.0],
		];

		yield [
			[0, 255, 255, 255],
			[180, 100, 50, 1.0],
		];
	}

	/**
	 * @dataProvider hslConversionValuesProvider
	 */
	public function testHslConversion(array $rgba, array $hsla): void {
		$color = Color::fromRGBA($rgba[0], $rgba[1], $rgba[2], $rgba[3]);
		$arr = $color->toHslArray();
		static::assertEquals($hsla[0], $arr['hue']);
		static::assertEquals($hsla[1], $arr['saturation']);
		static::assertEquals($hsla[2], $arr['lightness']);
		static::assertEquals($hsla[3], $arr['alpha']);
		$color2 =
			Color::fromHSLA($arr['hue'], $arr['saturation'], $arr['lightness'], $arr['alpha']);
		static::assertEquals($color->toHex(), $color2->toHex());
	}
}