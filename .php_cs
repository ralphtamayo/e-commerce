<?php

$finder = PhpCsFixer\Finder::create()
	->in(__DIR__.'/src')
;

return PhpCsFixer\Config::create()
	->setRules([
		'@PSR2' => true,
		'@Symfony' => true,

		'array_syntax' => ['syntax' => 'short'],
		'no_useless_else' => true,
		'no_useless_return' => true,
		'ordered_class_elements' => true,
		'ordered_imports' => true,
		'phpdoc_order' => true,
	])
	->setIndent("\t")
	->setFinder($finder)
;
