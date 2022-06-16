<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum VerticalAlignment: string {
	use HasEnumHashCode;

	case Auto = 'auto';
	case Start = 'flex-start';
	case Center = 'center';
	case End = 'flex-end';
	case Stretch = 'stretch';
	case Baseline = 'baseline';
}
