<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

class BorderSide implements Hashable, Stringable, Equatable {
	public static function solid(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Solid,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function dashed(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Dashed,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function dotted(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Dotted,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function double(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Double,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function groove(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Groove,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function inset(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Inset,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function outset(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Outset,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
		);
	}

	public static function ridge(
		null|int|float|Length $width,
		null|int|Color $color = null
	): BorderSide {
		return new BorderSide(
			BorderStyle::Ridge,
			$width !== null ? Length::wrap($width) : null,
			$color !== null ? Color::wrap($color) : null,
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

	public function equals(mixed $other): bool {
		if (!$other instanceof self) {
			return false;
		}

		return $this->style === $other->style
			&& $this->width === $other->width
			&& $this->color === $other->color;
	}
}