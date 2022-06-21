<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

class BorderSide implements Hashable, Stringable {
	public static function solid(null|int|float|Length $width, ?Color $color = null): BorderSide {
		return new BorderSide(
			BorderStyle::Solid,
			Length::wrap($width),
			$color,
		);
	}

	public static function hidden(null|int|float|Length $width): BorderSide {
		return new BorderSide(
			BorderStyle::Hidden,
			Length::wrap($width),
			null,
		);
	}

	public static function none(): BorderSide {
		return new BorderSide(
			BorderStyle::None,
			null,
			null,
		);
	}

	public function __construct(
		protected readonly BorderStyle $style,
		protected readonly ?Length $width = null,
		protected readonly ?Color $color = null,
	) {}

	public function __toString(): string {
		$parts = [$this->style->value];

		if ($this->width !== null) {
			$parts[] = $this->width->toEmittable();
		}

		if ($this->color !== null) {
			$parts[] = $this->color->toHex();
		}

		return implode(' ', $parts);
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->style,
			$this->width,
			$this->color,
		);
	}
}