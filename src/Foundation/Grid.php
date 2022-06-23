<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class Grid extends HtmlRenderWidget {
	/** @var array<string, list<Widget>> */
	protected array $children = [];

	public function __construct(
		iterable $children,
	) {
		foreach ($children as $area => $child) {
			if ($child === null) {
				continue;
			}

			assert($child instanceof Widget, "Grid children must be widgets");

			$child->renderParent = $this;

			$this->children[$area] ??= [];
			$this->children[$area][] = new GridCell($child, $area);
		}
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->children,
		);
	}

	protected function renderContent(RenderContext $context): string {
		return $this->renderChildren($context);
	}

	private function renderChildren(RenderContext $context): string {
		$children = '';

		foreach ($this->children as $areaChildren) {
			foreach ($areaChildren as $child) {
				$children .= $child->render($context);
			}
		}

		return $children;
	}

	public function renderStyle(RenderContext $context): string {
		$childStyles = $this->renderChildStyles($context);
		$myStyleContent = parent::renderStyle($context);

		return $myStyleContent . $childStyles;
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context) . "display: grid;";

		$style .= "grid-template-areas: " . implode(
				' ',
				array_map(
					static function (string $area) {
						return "'$area'";
					},
					array_keys($this->children)
				)
			) . ";";

		return $style;
	}

	protected function renderChildStyles(RenderContext $context): string {
		$childStyles = '';
		foreach ($this->children as $areaChildren) {
			foreach ($areaChildren as $child) {
				$childStyles .= $child->renderStyle($context);
			}
		}
		return $childStyles;
	}
}