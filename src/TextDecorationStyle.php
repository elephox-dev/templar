<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum TextDecorationStyle: string implements Hashable {
	use HasEnumHashCode;

	case Solid = 'solid';
	case Double = 'double';
	case Dotted = 'dotted';
	case Dashed = 'dashed';
	case Wavy = 'wavy';
}