<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\Templar;
use Elephox\Templar\TextAlign;
use Elephox\Templar\TextStyle;

class Text extends HtmlRenderWidget {
	use RendersTextStyle;

	public function __construct(
		private readonly string $text,
		private readonly ?TextAlign $align = null,
		private readonly ?TextStyle $style = null,
	) {}

	protected function renderStyleContent(RenderContext $context): string {
		$style = "";

		if ($this->align !== null) {
			$style .= "text-align: {$this->align->value};";
		}

		if ($this->style !== null) {
			$style .= $this->renderTextStyle(
				$this->style,
				$context
			);
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
