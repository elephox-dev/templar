<?php
declare(strict_types=1);

namespace Elephox\Templar;

class DocumentMeta {
	public function __construct(
		public ?string $title = null,
		public string $language = 'en',
		public string $charset = 'utf-8',
	) {}
}
