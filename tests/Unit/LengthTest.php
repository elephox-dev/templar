<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use AssertionError;
use Elephox\Templar\Length;
use Elephox\Templar\LengthUnit;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\Length
 * @covers \Elephox\Templar\Offset
 * @covers \Elephox\Templar\Value
 * @uses   \Elephox\Templar\EnumStringable
 */
class LengthTest extends TestCase {
	public function wrapValuesProvider(): iterable {
		yield [
			null,
			null,
			new Length(
				0,
				LengthUnit::Px,
				2
			),
		];
		yield [
			1,
			null,
			new Length(
				1,
				LengthUnit::Px,
				2
			),
		];
		yield [
			null,
			LengthUnit::Em,
			new Length(
				0,
				LengthUnit::Em,
				2
			),
		];
		yield [
			1.2,
			LengthUnit::Em,
			new Length(
				1.2,
				LengthUnit::Em,
				2
			),
		];
	}

	/**
	 * @dataProvider wrapValuesProvider
	 */
	public function testWrap(
		null|int|float|Length $length,
		?LengthUnit $unit,
		Length $expected
	): void {
		if ($unit !== null) {
			$wrapped =
				Length::wrap(
					$length,
					$unit
				);
		} else {
			$wrapped = Length::wrap($length);
		}

		static::assertInstanceOf(
			Length::class,
			$wrapped
		);
		static::assertSame(
			$expected->value(),
			$wrapped->value()
		);
		static::assertSame(
			$expected->unit(),
			$wrapped->unit()
		);
		static::assertSame(
			$expected->precision(),
			$wrapped->precision()
		);
	}

	public function testZero(): void {
		$zero = Length::zero();

		static::assertSame(
			0.0,
			$zero->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$zero->unit()
		);
		static::assertSame(
			2,
			$zero->precision()
		);

		$zero = Length::zero(LengthUnit::Em);

		static::assertSame(
			0.0,
			$zero->value()
		);
		static::assertSame(
			LengthUnit::Em,
			$zero->unit()
		);
		static::assertSame(
			2,
			$zero->precision()
		);
	}

	public function testIn(): void {
		$inPx = Length::inPx(1.2);
		$inRem = Length::inRem(1.2);
		$inPercent = Length::inPercent(1.2);

		static::assertSame(
			1.2,
			$inPx->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$inPx->unit()
		);
		static::assertSame(
			2,
			$inPx->precision()
		);

		static::assertSame(
			1.2,
			$inRem->value()
		);
		static::assertSame(
			LengthUnit::Rem,
			$inRem->unit()
		);
		static::assertSame(
			2,
			$inRem->precision()
		);

		static::assertSame(
			1.2,
			$inPercent->value()
		);
		static::assertSame(
			LengthUnit::Percent,
			$inPercent->unit()
		);
		static::assertSame(
			2,
			$inPercent->precision()
		);
	}

	public function testAdd(): void {
		$a = Length::inPx(1.2);
		$b = Length::inPx(2.3);
		$c = $a->add($b);

		static::assertSame(
			3.5,
			$c->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$c->unit()
		);
		static::assertSame(
			2,
			$c->precision()
		);
	}

	public function testInvalidUnitsAdd(): void {
		$a = Length::inPx(1.2);
		$b = Length::inRem(2.3);

		$this->expectException(AssertionError::class);
		$this->expectExceptionMessage('Cannot add lengths with different units');

		$a->add($b);
	}

	public function testAs(): void {
		$l = Length::inPx(1.2);
		$o1 = $l->asX();

		static::assertSame(
			1.2,
			$o1->x->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$o1->x->unit()
		);
		static::assertSame(
			2,
			$o1->x->precision()
		);
		static::assertSame(
			0.0,
			$o1->y->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$o1->y->unit()
		);
		static::assertSame(
			2,
			$o1->y->precision()
		);

		$o2 = $l->asY();

		static::assertSame(
			0.0,
			$o2->x->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$o2->x->unit()
		);
		static::assertSame(
			2,
			$o2->x->precision()
		);
		static::assertSame(
			1.2,
			$o2->y->value()
		);
		static::assertSame(
			LengthUnit::Px,
			$o2->y->unit()
		);
		static::assertSame(
			2,
			$o2->y->precision()
		);
	}

	public function testToString(): void {
		$l = Length::inPx(1.2);
		static::assertSame(
			'1.2px',
			(string)$l,
		);
		static::assertSame((string)$l, $l->toEmittable());

		$l = Length::inRem(1.2);
		static::assertSame(
			'1.2rem',
			(string)$l,
		);
		static::assertSame((string)$l, $l->toEmittable());

		$l = Length::zero();
		static::assertSame(
			'0',
			(string)$l,
		);
		static::assertSame((string)$l, $l->toEmittable());
	}
}
