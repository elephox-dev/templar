<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum OverflowWrap: string implements Hashable {
	use HasEnumHashCode;

	case Normal = 'normal';
	case Anywhere = 'anywhere';
	case BreakWord = 'break-word';

	case Inherit = 'inherit';
	case Initial = 'initial';
	case Revert = 'revert';
	case RevertLayer = 'revert-layer';
	case Unset = 'unset';
}