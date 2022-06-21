<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Positionable;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class Stack extends HtmlRenderWidget {
	protected array $children;

	public function __construct(
		iterable $children,
	) {
		$this->children = [];
		foreach ($children as $child) {
			assert($child instanceof Widget, 'Children must be widgets');

			if ($child instanceof Positionable) {
				$this->children[] = $child;
				$child->maybeSetContext(PositionContext::Absolute);
			} else {
				$this->children[] =
					new Container(child: $child, position: PositionContext::Absolute);
			}
		}
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->children,
		);
	}

	public function renderStyle(RenderContext $context): string {
		$childStyles = $this->renderChildStyles($context);
		$myStyleContent = parent::renderStyle($context);

		return $myStyleContent . $childStyles;
	}

	protected function renderStyleContent(RenderContext $context): string {
		return parent::renderStyleContent($context) . 'position: relative;';
	}

	protected function renderChildStyles(RenderContext $context): string {
		$childStyles = '';
		foreach ($this->children as $child) {
			$childStyles .= $child->renderStyle($context);
		}
		return $childStyles;
	}

	protected function renderChild(RenderContext $context): string {
		return $this->renderChildren($context);
	}

	protected function renderChildren(RenderContext $context): string {
		$html = '';
		foreach ($this->children as $child) {
			$html .= $child->render($context);
		}
		return $html;
	}
}