<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\TextAlign;

class Text extends HtmlRenderWidget {
	public function __construct(
		private readonly string $text,
		private readonly ?TextAlign $align = null,
	) {}

	protected function renderStyleContent(RenderContext $context): string {
		$style = "";

		if ($this->align !== null) {
			$style .= "text-align: {$this->align->value};";
		}

		return $style;
	}

	protected function renderChild(RenderContext $context): string {
		return $this->text;
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			hexdec(substr(md5($this->text), 0, 8)),
			$this->align,
		);
	}
}
