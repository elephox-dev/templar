<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Border;
use Elephox\Templar\BorderSide;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Table extends HtmlRenderWidget {
	protected array $rows;

	public function __construct(
		iterable $rows,
		public readonly ?Border $cellBorder = null,
		public readonly ?Border $outerBorder = null,
	) {
		$this->rows = [];
		foreach ($rows as $row) {
			assert(
				$row instanceof TableRow || $row instanceof LateTableRow,
				'Table rows must be of type TableRow.'
			);

			$row->renderParent = $this;
			$this->rows[] = $row;
		}
	}

	protected function getTag(): string {
		return 'table';
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->rows,
			$this->cellBorder,
			$this->outerBorder,
		);
	}

	public function getCellBorder(): ?Border {
		return $this->cellBorder;
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = 'border-collapse: collapse;';

		if ($this->outerBorder !== null) {
			$style .= $this->outerBorder->toEmittable();
		}

		return $style;
	}

	public function renderStyle(RenderContext $context): string {
		return parent::renderStyle($context) . $this->renderRowStyles($context);
	}

	protected function renderRowStyles(RenderContext $context): string {
		$style = '';

		foreach ($this->rows as $row) {
			$style .= $row->renderStyle($context);
		}

		return $style;
	}

	protected function renderContent(RenderContext $context): string {
		return $this->renderRows($context);
	}

	protected function renderRows(RenderContext $context): string {
		$html = '';

		foreach ($this->rows as $row) {
			$html .= $row->render($context);
		}

		return $html;
	}
}