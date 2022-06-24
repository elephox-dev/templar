<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum Overflow: string implements Hashable {
	use HasEnumHashCode;

	case Visible = 'visible';
	case Hidden = 'hidden';
	case Scroll = 'scroll';
	case Auto = 'auto';
}