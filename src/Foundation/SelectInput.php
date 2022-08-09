<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class SelectInput extends HtmlRenderWidget {
	protected array $options = [];

	public function __construct(
		iterable $options,
		protected readonly ?bool $autocomplete = null,
		protected readonly bool $autofocus = false,
		protected readonly bool $disabled = false,
		protected readonly bool $multiple = false,
		protected readonly bool $required = false,
		protected readonly ?string $name = null,
		protected readonly ?string $id = null,
	) {
		foreach ($options as $option) {
			if (is_string($option)) {
				$option = new SelectOption($option);
			}

			assert($option instanceof SelectOption || $option instanceof SelectOptionGroup);

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

		if ($this->autocomplete !== null) {
			$attributes['autocomplete'] = $this->autocomplete;
		}

		if ($this->autofocus) {
			$attributes['autofocus'] = 'autofocus';
		}

		if ($this->disabled) {
			$attributes['disabled'] = 'disabled';
		}

		if ($this->multiple) {
			$attributes['multiple'] = 'multiple';
		}

		if ($this->required) {
			$attributes['required'] = 'required';
		}

		if ($this->name !== null) {
			$attributes['name'] = $this->name;
		}

		return $attributes;
	}

	protected function getTag(): string {
		return 'select';
	}
}