<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class LateTableRow extends LateWidget {
	protected function build(RenderContext $context): Widget {
		$result = ($this->buildCallback)($context, $this);

		if (!is_iterable($result)) {
			$result = [$result];
		}

		$row = new TableRow(
			cells: $result,
		);

		$row->renderParent = $this->renderParent;

		return $row;
	}
}