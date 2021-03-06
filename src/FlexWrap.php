<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum FlexWrap: string implements Hashable {
	use HasEnumHashCode;

	case NoWrap = 'nowrap';
	case Wrap = 'wrap';
	case WrapReverse = 'wrap-reverse';
}
