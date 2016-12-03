<?php
/**
 * MIT License
 * 
 * Copyright (c) 2016 MZ Desenvolvimento de Sistemas LTDA
 * 
 * @author Francimar Alves <mazinsw@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */
namespace Imposto\ICMS;
use Util;

/**
 * Tributção pelo ICMS
 * 20 - Com redução de base de cálculo, estende de
 * Normal
 */
class Reducao extends Normal {

	private $reducao;

	public function __construct($reducao = array()) {
		parent::__construct($reducao);
		$this->setTributacao('20');
	}

	public function getReducao($normalize = false) {
		if(!$normalize)
			return $this->reducao;
		return Util::toFloat($this->reducao);
	}

	public function setReducao($reducao) {
		$this->reducao = $reducao;
		return $this;
	}

	public function toArray() {
		$reducao = parent::toArray();
		$reducao['reducao'] = $this->getReducao();
		return $reducao;
	}

	public function fromArray($reducao = array()) {
		if($reducao instanceof Reducao)
			$reducao = $reducao->toArray();
		else if(!is_array($reducao))
			return $this;
		parent::fromArray($reducao);
		$this->setReducao($reducao['reducao']);
		return $this;
	}

	public function getNode($name = null) {
		$element = parent::getNode(is_null($name)?'ICMS20':$name);
		$dom = $element->ownerDocument;
		$element->appendChild($dom->createElement('pRedBC', $this->getReducao(true)));
		return $element;
	}

}