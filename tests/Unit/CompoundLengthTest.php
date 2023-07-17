<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\CompoundLength;
use Elephox\Templar\Length;
use Elephox\Templar\MathOperator;

it(
	'can be converted to string',
	static function () {
		$compound =
			new CompoundLength(
				[Length::inPx(1)],
				MathOperator::Plus
			);

		expect((string) $compound)->toBe('1px');

		$compound->concat(Length::inPx(2));

		expect((string) $compound)->toBe('3px');

		$compound->concat(Length::inRem(2));

		expect((string) $compound)->toBe('3px + 2rem');

		$compound->concat(
			new CompoundLength(
				[Length::inPx(3), Length::inRem(4)],
				MathOperator::Minus
			)
		);

		expect((string) $compound)->toBe('3px + (3px - 4rem) + 2rem');

		$compound->concat(
			new CompoundLength(
				[Length::inPx(5), Length::inRem(6)],
				MathOperator::Plus
			)
		);

		expect((string) $compound)->toBe('3px + (3px - 4rem) + 2rem + 5px + 6rem');
	}
);

it(
	'has a correct implementation of toEmittable',
	static function () {
		$compound = new CompoundLength(
			[Length::inPx(1)],
			MathOperator::Plus,
		);

		expect($compound->toEmittable())->toBe('1px');

		$compound->concat(Length::inPx(2));

		expect($compound->toEmittable())->toBe('3px');

		$compound->concat(Length::inRem(2));

		expect($compound->toEmittable())->toBe('calc(3px + 2rem)');
	}
);

it(
	'produces a unique hash code',
	static function () {

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

		expect($a->getHashCode())->toBe($b->getHashCode())->and($a->getHashCode())->not()->toBe(
			$c->getHashCode()
		)->and($a->getHashCode())->not()->toBe($d->getHashCode());
	}
);

it(
	'ignores null values passed to constructor',
	static function () {
		$compound = new CompoundLength(
			[Length::inPx(1), null, Length::inPx(2)],
			MathOperator::Plus
		);

		expect((string) $compound)->toBe('3px');
	}
);
