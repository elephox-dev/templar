<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Border;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class TableRow extends HtmlRenderWidget {
	protected array $cells;

	public function __construct(
		iterable $cells,
		protected readonly ?Border $border = null,
	) {
		$this->cells = [];
		foreach ($cells as $cell) {
			assert(
				$cell instanceof TableCell || $cell instanceof LateTableCell,
				'Table row cells must be of type TableCell.'
			);

			$cell->renderParent = $this;
			$this->cells[] = $cell;
		}
	}

	protected function getTag(): string {
		return 'tr';
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->cells,
			$this->border,
		);
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		if ($this->renderParent instanceof Table) {
			/** @var Border $border */
			$border = $this->border ?? $this->renderParent->getBorder($context);
			if ($border !== null) {
				$style .= $border->toEmittable();
			}
		}

		return $style;
	}

	public function renderStyle(RenderContext $context): string {
		return parent::renderStyle($context) . $this->renderCellStyles($context);
	}

	protected function renderCellStyles(RenderContext $context): string {
		$style = '';

		foreach ($this->cells as $cell) {
			$style .= $cell->renderStyle($context);
		}

		return $style;
	}

	protected function renderContent(RenderContext $context): string {
		return $this->renderRows($context);
	}

	protected function renderRows(RenderContext $context): string {
		$html = '';

		foreach ($this->cells as $cell) {
			$html .= $cell->render($context);
		}

		return $html;
	}
}