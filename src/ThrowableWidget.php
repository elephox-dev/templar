<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Throwable;

class ThrowableWidget extends RenderWidget {
	protected readonly int $firstContextLine;

	public function __construct(
		protected readonly Throwable $throwable,
		protected readonly int $numContextLines = 5,
	) {
		assert($numContextLines >= 0);

		$this->firstContextLine = max(0, $this->getLine() - $numContextLines - 1);
	}

	public function getHashCode(): float {
		return 0;
	}

	public function render(RenderContext $context): string {
		$relevantLines = $this->getSourceLines();
		$this->formatLines($relevantLines);
		$this->addLineNumbers($relevantLines);
		$relevantLinesStr = implode("\n", $relevantLines);

		return <<<HTML
<div style="background: red; color: yellow; border: yellow dashed 2px; width: 100%; height: 100%; overflow: auto; padding: 4px; font-family: sans-serif">
	<p style="margin: 0 0 1rem 0">
		{$this->getMessage()}<br />
		<em>in {$this->getFile()}:{$this->getLine()}</em>
	</p>
	<details open>
		<summary>Source</summary>
		<pre style="margin: 0; overflow:auto; background: #333; color: #ccc; padding: 4px;">$relevantLinesStr</pre>
	</details>
	<details>
		<summary>Stack trace</summary>
		<pre style="margin: 0; overflow: auto;">{$this->getTraceAsString()}</pre>
	</details>
</div>
HTML;
	}

	public function renderStyle(RenderContext $context): string {
		return '';
	}

	protected function getSourceLines(bool $all = false): array {
		$source = file_get_contents($this->getFile());
		$lines = explode("\n", $source);

		if ($all) {
			return $lines;
		}

		return array_slice(
			$lines,
			$this->firstContextLine,
			$this->numContextLines * 2 + 1,
		);
	}

	protected function formatLines(array &$lines): void {
		$firstMeaningfulCharacterIndex = PHP_INT_MAX;
		$firstCharacterIndexes = [];
		foreach ($lines as &$line) {
			$line = htmlentities($line);
			$length = strlen($line);
			$trimmed = ltrim($line);
			$trimmedLength = strlen($trimmed);

			if ($trimmedLength === 0) {
				$firstCharacterIndexes[] = $firstMeaningfulCharacterIndex;
				$line = $trimmed;

				continue;
			}

			$firstCharacterIdx = $length - $trimmedLength;
			$firstCharacterIndexes[] = $firstCharacterIdx;
			if ($firstCharacterIdx < $firstMeaningfulCharacterIndex) {
				$firstMeaningfulCharacterIndex = $firstCharacterIdx;
			}

			$line = $trimmed;
		}
		unset($line);

		foreach ($lines as $i => &$line) {
			$line =
				$this->padLine($line, $firstCharacterIndexes[$i] - $firstMeaningfulCharacterIndex);
		}
	}

	protected function padLine(string $line, int $indent): string {
		return str_repeat("\t", $indent) . $line;
	}

	protected function addLineNumbers(array &$lines): void {
		foreach ($lines as $i => &$line) {
			$actualLine = $i + 1 + $this->firstContextLine;
			$actualLineFmt = $this->formatLineNumber($actualLine);
			$line = "$actualLineFmt $line";

			if ($actualLine === $this->getLine()) {
				$line = $this->highlightLine($line);
			}
		}

		unset($line);
	}

	protected function highlightLine(string $line): string {
		return "<span style='background: white; color: black;'>$line</span>";
	}

	protected function formatLineNumber(int $line): string {
		return str_pad((string)$line, 3, " ", STR_PAD_LEFT);
	}

	public function getMessage(): string {
		return $this->throwable->getMessage();
	}

	public function getCode(): int {
		return $this->throwable->getCode();
	}

	public function getFile(): string {
		return $this->throwable->getFile();
	}

	public function getLine(): int {
		return $this->throwable->getLine();
	}

	public function getTrace(): array {
		return $this->throwable->getTrace();
	}

	public function getTraceAsString(): string {
		return $this->throwable->getTraceAsString();
	}

	public function getPrevious(): ?Throwable {
		return $this->throwable->getPrevious();
	}

	public function __toString(): string {
		return (string)$this->throwable;
	}
}