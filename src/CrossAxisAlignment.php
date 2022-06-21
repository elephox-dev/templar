<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum CrossAxisAlignment: string implements Hashable {
	use HasEnumHashCode;

	case Start = 'flex-start';
	case Center = 'center';
	case End = 'flex-end';
	case Stretch = 'stretch';
	case Baseline = 'baseline';
}
