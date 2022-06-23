<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum ButtonType: string implements Hashable {
	use HasEnumHashCode;

	case Submit = 'submit';
	case Reset = 'reset';
	case Button = 'button';
}