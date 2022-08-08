<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\InputType;
use Elephox\Templar\RenderContext;

class ImageInput extends Input {
	public function __construct(
		?bool $autocomplete = null,
		bool $autofocus = false,
		bool $disabled = false,
		bool $formnovalidate = false,
		?string $list = null,
		?string $name = null,
		?string $pattern = null,
		?string $placeholder = null,
		bool $readonly = false,
		bool $required = false,
		?int $size = null,
		?string $value = null,
		protected readonly ?string $alt = null,
		protected readonly ?string $formaction = null,
		protected readonly ?string $formenctype = null,
		protected readonly ?string $formmethod = null,
		protected readonly ?string $formtarget = null,
		protected readonly ?int $height = null,
		protected readonly ?int $width = null,
	) {
		parent::__construct(
			InputType::Image,
			$autocomplete,
			$autofocus,
			$disabled,
			$formnovalidate,
			$list,
			$name,
			$pattern,
			$placeholder,
			$readonly,
			$required,
			$size,
			$value,
		);
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->type,
		);
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		if ($this->alt !== null) {
			$attributes['alt'] = $this->alt;
		}

		if ($this->formaction !== null) {
			$attributes['formaction'] = $this->formaction;
		}

		if ($this->formenctype !== null) {
			$attributes['formenctype'] = $this->formenctype;
		}

		if ($this->formmethod !== null) {
			$attributes['formmethod'] = $this->formmethod;
		}

		if ($this->formtarget !== null) {
			$attributes['formtarget'] = $this->formtarget;
		}

		if ($this->height !== null) {
			$attributes['height'] = $this->height;
		}

		if ($this->width !== null) {
			$attributes['width'] = $this->width;
		}

		return $attributes;
	}
}