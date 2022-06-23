<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TableScope;
use Elephox\Templar\Widget;

class LateTableCell extends LateWidget {
	public function __construct(
		Closure $buildCallback,
		protected readonly bool $isHeader = false,
		protected readonly ?TableScope $scope = null,
		protected readonly ?int $colspan = null,
		protected readonly ?int $rowspan = null,
	) {
		parent::__construct($buildCallback);
	}

	protected function build(RenderContext $context): Widget {
		$result = ($this->buildCallback)($context, $this);

		$cell = new TableCell(
			child: $result,
			isHeader: $this->isHeader,
			scope: $this->scope,
			colspan: $this->colspan,
			rowspan: $this->rowspan,
		);

		$cell->renderParent = $this->renderParent;

		return $cell;
	}
}