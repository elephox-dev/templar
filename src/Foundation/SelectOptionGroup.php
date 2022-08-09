<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class SelectOptionGroup extends HtmlRenderWidget {
	protected array $options = [];

	public function __construct(
		protected readonly string $label,
		iterable $options,
		protected readonly bool $disabled = false,
	) {
		foreach ($options as $option) {
			if (is_string($option)) {
				$option = new SelectOption($option);
			}

			assert($option instanceof SelectOption);

			$option->renderParent = $this;
			$this->options[] = $option;
		}
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash();
	}

	protected function renderContent(RenderContext $context): string {
		return $this->renderChildren($context);
	}

	protected function renderChildren(RenderContext $context): string {
		$children = '';

		foreach ($this->options as $option) {
			$children .= $option->render($context);
		}

		return $children;
	}

	public function renderStyle(RenderContext $context): string {
		$childStyles = $this->renderChildStyles($context);
		$myStyleContent = parent::renderStyle($context);

		return $myStyleContent . $childStyles;
	}

	protected function renderChildStyles(RenderContext $context): string {
		$childStyles = '';
		foreach ($this->options as $option) {
			$childStyles .= $option->renderStyle($context);
		}
		return $childStyles;
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);
		$attributes['label'] = $this->label;

		if ($this->disabled) {
			$attributes['disabled'] = 'disabled';
		}

		return $attributes;
	}

	protected function getTag(): string {
		return 'optgroup';
	}
}