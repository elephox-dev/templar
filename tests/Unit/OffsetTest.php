<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\AbsoluteLengthUnit;
use Elephox\Templar\Length;
use Elephox\Templar\LengthUnit;
use Elephox\Templar\Offset;
use Elephox\Templar\RelativeLengthUnit;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\Offset
 * @covers \Elephox\Templar\Length
 * @covers \Elephox\Templar\Value
 * @covers \Elephox\Templar\HashBuilder
 * @uses   \Elephox\Templar\EnumStringable
 */
class OffsetTest extends TestCase {
	public function bothValuesProvider(): iterable {
		yield [null, 0, AbsoluteLengthUnit::Px, 0, AbsoluteLengthUnit::Px];
		yield [1, 1, AbsoluteLengthUnit::Px, 1, AbsoluteLengthUnit::Px];
		yield [1.5, 1.5, AbsoluteLengthUnit::Px, 1.5, AbsoluteLengthUnit::Px];
		yield [Length::inRem(1), 1, RelativeLengthUnit::Rem, 1, RelativeLengthUnit::Rem];
	}

	/**
	 * @dataProvider bothValuesProvider
	 */
	public function testBoth(
		null|int|float|Length $input,
		float $valueX,
		LengthUnit $unitX,
		float $valueY,
		LengthUnit $unitY
	): void {
		$offset = Offset::both($input);

		static::assertEquals(
			$valueX,
			$offset->x->value()
		);
		static::assertEquals(
			$unitX,
			$offset->x->unit()
		);
		static::assertEquals(
			$valueY,
			$offset->y->value()
		);
		static::assertEquals(
			$unitY,
			$offset->y->unit()
		);
	}

	public function toStringValuesProvider(): iterable {
		yield [null, null, '0 0'];
		yield [1, 1.5, '1px 1.5px'];
		yield [null, 1.5, '0 1.5px'];
		yield [1.5, null, '1.5px 0'];
		yield [Length::inRem(1), Length::inPercent(50), '1rem 50%'];
	}

	/**
	 * @dataProvider toStringValuesProvider
	 */
	public function testToString(
		null|int|float|Length $x,
		null|int|float|Length $y,
		string $result
	): void {
		$offset =
			new Offset(
				$x,
				$y
			);

		static::assertEquals(
			$result,
			$offset->__toString()
		);
	}

	public function testWith(): void {
		$a =
			new Offset(
				1,
				2
			);
		$b = $a->with(x: 3);
		$c = $a->with(y: 4);

		static::assertEquals(
			1,
			$a->x->value()
		);
		static::assertEquals(
			2,
			$a->y->value()
		);
		static::assertEquals(
			3,
			$b->x->value()
		);
		static::assertEquals(
			2,
			$b->y->value()
		);
		static::assertEquals(
			1,
			$c->x->value()
		);
		static::assertEquals(
			4,
			$c->y->value()
		);
	}

	public function testGetHashCode(): void {
		$a =
			new Offset(
				1,
				2
			);
		$b =
			new Offset(
				1,
				2
			);
		$c =
			new Offset(
				1,
				3
			);
		$d =
			new Offset(
				2,
				2
			);

		static::assertEquals(
			$a->getHashCode(),
			$b->getHashCode()
		);
		static::assertNotEquals(
			$a->getHashCode(),
			$c->getHashCode()
		);
		static::assertNotEquals(
			$a->getHashCode(),
			$d->getHashCode()
		);
		static::assertNotEquals(
			$c->getHashCode(),
			$d->getHashCode()
		);
	}
}
