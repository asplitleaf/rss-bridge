<?php
class AnkRougeBridge extends BridgeAbstract {

	const NAME = 'Ank Rouge';
	const URI = 'http://blog.ailand-store.jp/ar0164/';
	const DESCRIPTION = 'Returns staff posts from Ank Rouge Ailand blog';
	const MAINTAINER = 'asplitleaf';

	public function collectData() {
		$html = getSimpleHTMLDOMCached(self::getURI())
			or returnServerError('Could not load content');

		$mainUrl = "http://blog.ailand-store.jp";

		foreach($html->find('.entry.section') as $element) {
			$item = array();

			$snippet = $element->find('.content .text', 0);
			$link = $element->find('.title a', 0);

			$item['title'] = $link->plaintext;
			$item['uri'] = $mainUrl . $link->href;
			$item['timestamp'] = strtotime($element->find('p.date', 0)->plaintext);

			$content = $snippet->innertext;
			$content = str_replace("/data/", $mainUrl . "/data/", $content);
			$item['content'] = $content;

			$this->items[] = $item;
		}

	}
}
