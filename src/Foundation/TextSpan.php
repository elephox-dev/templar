<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\TextStyle;
use InvalidArgumentException;

class TextSpan extends HtmlRenderWidget {
	use RendersTextStyle;

	protected array $children;

	public function __construct(
		protected readonly string $text,
		protected readonly ?TextStyle $style = null,
		iterable $children = [],
	) {
		$this->children = [];
		foreach ($children as $child) {
			if (!$child instanceof self) {
				throw new InvalidArgumentException(
					'TextSpan children must be TextSpan instances'
				);
			}

			$this->children[] = $child;
		}
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->style,
		);
	}

	protected function renderContent(RenderContext $context): string {
		return $this->text . $this->renderChildren($context);
	}

	private function renderChildren(RenderContext $context): string {
		$children = '';

		foreach ($this->children as $child) {
			$children .= $child->render($context);
		}

		return $children;
	}

	protected function getTag(): string {
		return 'span';
	}

	public function renderStyle(RenderContext $context): string {
		$childStyles = $this->renderChildStyles($context);
		$myStyleContent = parent::renderStyle($context);

		return $myStyleContent . $childStyles;
	}

	protected function renderChildStyles(RenderContext $context): string {
		$childStyles = '';
		foreach ($this->children as $child) {
			$childStyles .= $child->renderStyle($context);
		}
		return $childStyles;
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = '';

		if ($this->style !== null) {
			$style .= $this->renderTextStyle(
				$this->style,
				$context
			);
		}

		return $style;
	}
}