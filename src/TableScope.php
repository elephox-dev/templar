<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum TableScope: string implements Hashable {
	use HasEnumHashCode;

	case Column = 'col';
	case Row = 'row';
	case ColumnGroup = 'colgroup';
	case RowGroup = 'rowgroup';
}