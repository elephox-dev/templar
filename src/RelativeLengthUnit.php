<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum RelativeLengthUnit: string implements LengthUnit {
	use HasEnumHashCode;
	use EnumStringable;

	case Em = 'em';
	case Ex = 'ex';
	case Ch = 'ch';
	case Rem = 'rem';
	case Vw = 'vw';
	case Vh = 'vh';
	case Vmin = 'vmin';
	case Vmax = 'vmax';
	case Percent = '%';
}