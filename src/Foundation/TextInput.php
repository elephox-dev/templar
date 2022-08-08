<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\InputType;
use Elephox\Templar\RenderContext;

class TextInput extends Input {
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
		protected readonly ?string $dirname = null,
	) {
		parent::__construct(
			InputType::Text,
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

		if ($this->dirname !== null) {
			$attributes['dirname'] = $this->dirname;
		}

		return $attributes;
	}
}