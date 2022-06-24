<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum WhiteSpace: string implements Hashable {
	use HasEnumHashCode;

	case Normal = 'normal';
	case NoWrap = 'nowrap';
	case Pre = 'pre';
	case PreWrap = 'pre-wrap';
	case PreLine = 'pre-line';
	case BreakSpaces = 'break-spaces';
}