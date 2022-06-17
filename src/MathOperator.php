<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum MathOperator: string implements Hashable {
	use HasEnumHashCode;

	case Plus = '+';
	case Minus = '-';
	case Multiply = '*';
	case Divide = '/';
	case Modulo = '%';
}