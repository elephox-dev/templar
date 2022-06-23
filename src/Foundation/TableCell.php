<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Border;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TableScope;
use Elephox\Templar\Widget;

class TableCell extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly bool $isHeader = false,
		protected readonly ?TableScope $scope = null,
		protected readonly ?int $colspan = null,
		protected readonly ?int $rowspan = null,
		protected readonly ?Border $border = null,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	protected function getTag(): string {
		return $this->isHeader ? 'th' : 'td';
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		if ($this->scope !== null) {
			$attributes['scope'] = $this->scope->value;
		}

		if ($this->colspan !== null) {
			$attributes['colspan'] = $this->colspan;
		}

		if ($this->rowspan !== null) {
			$attributes['rowspan'] = $this->rowspan;
		}

		return $attributes;
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		$border = $this->border;
		if ($this->renderParent instanceof TableRow) {
			/** @var TableRow $row */
			$row = $this->renderParent;

			$border ??= $row->getCellBorder();

			if ($row->renderParent instanceof Table) {
				/** @var Table $table */
				$table = $row->renderParent;

				$border ??= $table->getCellBorder();
			}
		}

		if ($border !== null) {
			$style .= $border->toEmittable();
		}

		return $style;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->child,
			$this->isHeader,
			$this->scope,
			$this->border,
		);
	}
}