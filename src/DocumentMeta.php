<?php
declare(strict_types=1);

namespace Elephox\Templar;

class DocumentMeta implements Hashable {
	public function __construct(
		public ?string $title = null,
		public string $language = 'en',
		public string $charset = 'utf-8',
		public array $metas = [
			'viewport' => 'width=device-width, initial-scale=1',
		],
	) {}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->title,
			$this->language,
			$this->charset,
			$this->metas,
		);
	}
}
