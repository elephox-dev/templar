<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\OverflowWrap;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\TextAlign;
use Elephox\Templar\WhiteSpace;
use Elephox\Templar\WordBreak;
use Elephox\Templar\TextStyle;
use Elephox\Templar\WordWrap;

class Text extends HtmlRenderWidget {
	use RendersTextStyle;

	public function __construct(
		private readonly string $text,
		private readonly ?TextAlign $align = null,
		private readonly ?TextStyle $style = null,
		private readonly ?WordBreak $break = null,
		private readonly ?WordWrap $wrap = null,
		private readonly ?OverflowWrap $overflow = null,
		private readonly ?WhiteSpace $whiteSpace = null,
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

		if ($this->break !== null) {
			$style .= "word-break: {$this->break->value};";
		}

		if ($this->wrap !== null) {
			$style .= "word-wrap: {$this->wrap->value};";
		}

		if ($this->overflow !== null) {
			$style .= "overflow-wrap: {$this->overflow->value};";
		}

		if ($this->whiteSpace !== null) {
			$style .= "white-space: {$this->whiteSpace->value};";
		}

		return $style;
	}

	protected function getTag(): string {
		return 'span';
	}

	protected function renderContent(RenderContext $context): string {
		return $this->text;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->text,
			$this->align,
			$this->break,
			$this->wrap,
			$this->overflow,
			$this->whiteSpace,
		);
	}
}
