<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum AbsoluteLengthUnit: string implements LengthUnit {
	use HasEnumHashCode;
	use EnumStringable;

	case In = 'in';
	case Cm = 'cm';
	case Mm = 'mm';
	case Px = 'px';
	case Pt = 'pt';
	case Pc = 'pc';
}
