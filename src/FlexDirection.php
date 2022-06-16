<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum FlexDirection: string {
	use HasEnumHashCode;

	case Row = 'row';
	case RowReverse = 'row-reverse';
	case Column = 'column';
	case ColumnReverse = 'column-reverse';
}
