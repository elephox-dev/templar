<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use AssertionError;
use Elephox\Templar\Angle;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\LinearGradient;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\LinearGradient
 * @covers \Elephox\Templar\Gradient
 * @covers \Elephox\Templar\Color
 * @covers \Elephox\Templar\Foundation\Colors
 * @covers \Elephox\Templar\Angle
 * @covers \Elephox\Templar\Value
 * @covers \Elephox\Templar\Templar::combineHashCodes
 * @uses   \Elephox\Templar\EnumStringable
 * @uses   \Elephox\Templar\HasEnumHashCode
 */
class LinearGradientTest extends TestCase {
	public function toStringValuesProvider(): iterable {
		yield [
			new LinearGradient(
				[
					Colors::White(),
					Colors::Black(),
				],
			),
			"linear-gradient(to right, #FFFFFFFF 0%, #000000FF 100%)",
		];
		yield [
			new LinearGradient(
				[
					Colors::Black(),
					Colors::White(),
					Colors::Red(),
					Colors::Blue(),
				],
				Angle::inDeg(45),
			),
			"linear-gradient(45deg, #000000FF 0%, #FFFFFFFF 100%, #FF0000FF 200%, #0000FFFF 300%)",
		];
	}

	/**
	 * @dataProvider toStringValuesProvider
	 */
	public function testToString(LinearGradient $gradient, string $result): void {
		static::assertSame(
			$result,
			(string)$gradient,
		);
	}

	public function testInvalidLinearGradientEmptyStops(): void {
		$this->expectException(AssertionError::class);
		$this->expectExceptionMessage("LinearGradient must have at least two stops, got 0");

		new LinearGradient([]);
	}

	public function testInvalidLinearGradientTooLittleStops(): void {
		$this->expectException(AssertionError::class);
		$this->expectExceptionMessage("LinearGradient must have at least two stops, got 1");

		new LinearGradient([Colors::Red()]);
	}

	public function testGetHashCode(): void {
		$a = new LinearGradient([Colors::Red(), Colors::Blue()]);
		$b = new LinearGradient([Colors::Red(), Colors::Black()]);
		$c = new LinearGradient([Colors::Red(), Colors::Black()]);

		static::assertNotSame($a->getHashCode(), $b->getHashCode());
		static::assertSame($b->getHashCode(), $c->getHashCode());
	}
}
