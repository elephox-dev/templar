<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum Target: string {
	use HasEnumHashCode;

	case Blank = '_blank';
	case Parent = '_parent';
	case Self = '_self';
	case Top = '_top';
}