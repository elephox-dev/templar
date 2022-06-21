<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum TextDecorationPosition: string implements Hashable {
	use HasEnumHashCode;

	case Underline = 'underline';
	case Overline = 'overline';
	case LineThrough = 'line-through';
	case None = 'none';
}