<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum AngleUnit: string implements ValueUnit {
	use HasEnumHashCode;
	use EnumStringable;

	case Deg = 'deg';
	case Rad = 'rad';
}