<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum ReferrerPolicy: string {
	use HasEnumHashCode;

	case NoReferrer = 'no-referer';
	case NoReferrerWhenDowngrade = 'no-referrer-when-downgrade';
	case Origin = 'origin';
	case OriginWhenCrossOrigin = 'origin-when-cross-origin';
	case SameOrigin = 'same-origin';
	case StrictOriginWhenCrossOrigin = 'strict-origin-when-cross-origin';
	case UnsafeUrl = 'unsafe-url';
}