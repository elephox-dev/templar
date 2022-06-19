<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\CompoundLength;
use Elephox\Templar\Length;
use Elephox\Templar\MathOperator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\CompoundLength
 * @covers \Elephox\Templar\Length
 * @covers \Elephox\Templar\Value
 * @covers \Elephox\Templar\Templar::combineHashCodes
 * @uses   \Elephox\Templar\EnumStringable
 * @uses   \Elephox\Templar\HasEnumHashCode
 */
class CompoundLengthTest extends TestCase {
	public function testToString(): void {
		$compound =
			new CompoundLength(
				[Length::inPx(1)],
				MathOperator::Plus
			);

		static::assertSame(
			'1px',
			(string) $compound
		);
		static::assertSame(
			'1px',
			$compound->toEmittable()
		);

		$compound->concat(Length::inPx(2));

		static::assertSame(
			'1px + 2px',
			(string) $compound
		);
		static::assertSame(
			'calc(1px + 2px)',
			$compound->toEmittable()
		);

		$compound->concat(Length::inRem(2));

		static::assertSame(
			'1px + 2px + 2rem',
			(string) $compound
		);
		static::assertSame(
			'calc(1px + 2px + 2rem)',
			$compound->toEmittable()
		);

		$compound->concat(
			new CompoundLength(
				[Length::inPx(3), Length::inRem(4)],
				MathOperator::Minus
			)
		);

		static::assertSame(
			'1px + 2px + 2rem + (3px - 4rem)',
			(string) $compound
		);
		static::assertSame(
			'calc(1px + 2px + 2rem + (3px - 4rem))',
			$compound->toEmittable()
		);

		$compound->concat(
			new CompoundLength(
				[Length::inPx(5), Length::inRem(6)],
				MathOperator::Plus
			)
		);

		static::assertSame(
			'1px + 2px + 2rem + (3px - 4rem) + 5px + 6rem',
			(string) $compound
		);
		static::assertSame(
			'calc(1px + 2px + 2rem + (3px - 4rem) + 5px + 6rem)',
			$compound->toEmittable()
		);
	}

	public function testGetHashCode(): void {
		$a =
			new CompoundLength(
				[Length::inPx(1)],
				MathOperator::Plus
			);
		$b =
			new CompoundLength(
				[Length::inPx(1)],
				MathOperator::Plus
			);
		$c =
			new CompoundLength(
				[Length::inPx(2)],
				MathOperator::Plus
			);
		$d =
			new CompoundLength(
				[Length::inPx(1)],
				MathOperator::Minus
			);

		static::assertSame(
			$a->getHashCode(),
			$b->getHashCode()
		);
		static::assertNotSame(
			$a->getHashCode(),
			$c->getHashCode()
		);
		static::assertNotSame(
			$a->getHashCode(),
			$d->getHashCode()
		);
	}

	public function testNullValuesAreIgnored(): void {
		$compound = new CompoundLength(
			[Length::inPx(1), null, Length::inPx(2)],
			MathOperator::Plus
		);

		static::assertSame(
			'1px + 2px',
			(string)$compound
		);
	}
}
