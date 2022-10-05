<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use AssertionError;
use Elephox\Templar\Color;
use Elephox\Templar\Length;
use Elephox\Templar\TextAlign;
use Elephox\Templar\TextStyle;

it(
	'allows setting valid values',
	function () {
		$style = new TextStyle(
			font: 'Arial',
			size: Length::inPx(12),
			weight: 'bold',
			align: TextAlign::Center,
			color: new Color(0xff0000ff),
		);

		expect($style->font)->toBe('Arial')
			->and($style->size->value())->toBe(12.0)
			->and($style->weight)->toBe('bold')
			->and($style->align)->toBe(TextAlign::Center)
			->and($style->color->toHex())->toBe("#FF0000FF");
	}
);

it(
	'throws for invalid weight multiple',
	function () {
		new TextStyle(weight: 123);
	}
)->throws(
	AssertionError::class,
	"Weight must be a multiple of 100, but 123 was given",
);

it(
	'throws for invalid weight range',
	function (int $weight) {
		expect(static fn() => new TextStyle(weight: $weight))->toThrow(
			AssertionError::class,
			sprintf("Weight must be between 100 and 900 (inclusive), but %s was given", $weight)
		);
	}
)
	->with(
		[
			-100,
			1000
		]
	);

it(
	'accepts HTML weight values',
	function (string $weight) {
		$style = new TextStyle(weight: $weight);

		expect($style->weight)->toBe($weight);
	}
)->with(
	[
		'lighter',
		'normal',
		'bold',
		'bolder',
	]
);

it(
	'throws for invalid textual weight values',
	function (string $weight) {
		expect(static fn() => new TextStyle(weight: $weight))->toThrow(
			AssertionError::class,
			sprintf(
				"Weight must be one of 'normal', 'bold', 'lighter', 'bolder', but '%s' was given",
				$weight
			)
		);
	}
)->with(
	[
		'text',
		'boldest',
		''
	]
);

it(
	'allows overwriting values',
	function () {
		$textStyle = new TextStyle(
			font: 'Arial',
			size: Length::inPx(12),
			weight: 'bold',
			align: TextAlign::Center,
			color: new Color(0xff0000ff),
		);

		$overwrittenStyle = $textStyle->overwriteFrom(
			new TextStyle(
				font: 'Helvetica',
				size: Length::inPx(14),
				weight: 'normal',
				align: TextAlign::Left,
				color: new Color(0x00ff00ff),
			),
		);

		expect($overwrittenStyle->font)->toBe('Helvetica')
			->and($overwrittenStyle->size->value())->toBe(14.0)
			->and($overwrittenStyle->weight)->toBe('normal')
			->and($overwrittenStyle->align)->toBe(TextAlign::Left)
			->and($overwrittenStyle->color->toHex())->toBe("#00FF00FF");
	}
);

it(
	'returns the same instance if overwriting with null',
	function () {
		$textStyle = new TextStyle(
			font: 'Arial',
			size: Length::inPx(12),
			weight: 'bold',
			align: TextAlign::Center,
			color: new Color(0xff0000ff),
		);

		$overwrittenStyle = $textStyle->overwriteFrom(null);

		expect($overwrittenStyle)->toBe($textStyle);
	}
);
