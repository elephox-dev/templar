<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum WordWrap: string implements Hashable {
	use HasEnumHashCode;

	case Normal = 'normal';
	case BreakWord = 'break-word';

	case Initial = 'initial';
	case Inherit = 'inherit';
}