<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum WordBreak: string implements Hashable {
	use HasEnumHashCode;

	case Normal = 'normal';
	case BreakAll = 'break-all';
	case KeepAll = 'keep-all';

	/** @deprecated Use WordBreak::Normal and OverflowWrap::Anywhere instead */
	case BreakWord = 'break-word';

	case Inherit = 'inherit';
	case Initial = 'initial';
	case Revert = 'revert';
	case RevertLayer = 'revert-layer';
	case Unset = 'unset';
}