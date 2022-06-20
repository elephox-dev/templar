<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum LengthUnit: string implements ValueUnit, Hashable {
	use HasEnumHashCode;
	use EnumStringable;

	case Px = 'px';
	case Em = 'em';
	case Rem = 'rem';
	case Percent = '%';
	case Vh = 'vh';
	case Vw = 'vw';
}
