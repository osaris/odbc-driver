<?php namespace Ccovey\ODBCDriver;

use Illuminate\Database\Connection;

class ODBCDriverConnection extends Connection
{
	/**
	 * @return Query\Grammars\Grammar
	 */
	protected function getDefaultQueryGrammar()
	{
		$grammarConfig = $this->getGrammarConfig();

		if ($grammarConfig) {
			$packageGrammar = "Ccovey\\ODBCDriver\\Grammars\\" . $grammarConfig;
			if (class_exists($packageGrammar)) {
				return $this->withTablePrefix(new $packageGrammar);
			}

			$illuminateGrammar = "Illuminate\\Database\\Query\\Grammars\\" . $grammarConfig;
			if (class_exists($illuminateGrammar)) {
				return $this->withTablePrefix(new $illuminateGrammar);
			}
		}

		return $this->withTablePrefix(new Grammar);
	}

	protected function getDefaultPostProcessor()
	{
		$grammarConfig = $this->getGrammarConfig();
		if($grammarConfig) {
			$packageProcessor = "Ccovey\\ODBCDriver\\Processors\\" . $grammarConfig;
			if (class_exists($packageProcessor)) {
				return new $packageProcessor;
			}
		}

		return new Processor;
	}

	/**
	 * Default grammar for specified Schema
	 * @return Schema\Grammars\Grammar
	 */
	protected function getDefaultSchemaGrammar()
	{
		return $this->withTablePrefix(new Schema\Grammars\Grammar);
	}

	protected function getGrammarConfig()
	{
		if ($this->getConfig('grammar')) {
			return $this->getConfig('grammar');
		}

		return false;
	}
}
