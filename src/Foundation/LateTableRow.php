<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\Border;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class LateTableRow extends LateWidget {
	public function __construct(
		Closure $buildCallback,
		protected readonly ?Border $cellBorder = null,
		protected readonly ?Border $outerBorder = null,
	) {
		parent::__construct($buildCallback);
	}

	protected function build(RenderContext $context): Widget {
		$result =
			($this->buildCallback)(
				$context,
				$this
			);

		if (!is_iterable($result)) {
			$result = [$result];
		}

		$row = new TableRow(
			cells: $result,
			cellBorder: $this->cellBorder,
			outerBorder: $this->outerBorder,
		);

		$row->renderParent = $this->renderParent;

		return $row;
	}
}