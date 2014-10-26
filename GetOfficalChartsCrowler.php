<?php
function k($t, $l)
{
	for ($i = 0; $i < $l; $i++) {
		$str = date('Y-m-d', $t);
		$content = file_get_contents("http://www.officialcharts.com/archive-chart/_/1/$str/");
		libxml_use_internal_errors(true);
		$DOM = new DOMDocument();
		$DOM->loadHTML($content);
		foreach($DOM->getElementsByTagName('td') as $node) {
			$array[] = $DOM->saveHTML($node);
		}
		$n = count($array);
		$result = "";
		for ($c = 0; $c < 40; $c++) {
			$a = $array[5 * $c + 3];
			$t1 = strpos($a, "<h3>");
			$t2 = strpos($a, "</h4>");
			$result = $result . substr($a, $t1, $t2 - $t1) . "<br />";
		}

		$patterns = array(
			"\r\n",
			"                  ",
			"<h3>",
			"</h3>",
			"<h4>"
		);
		$result = str_replace($patterns, "", $result);
		$result = str_replace("<br />", "<br />\r\n", $result);
		echo "$str:<br />\r\n$result";
	}
}

k(1414800001, 1); // k('start time(must be a sunday UNIX time)', '# of weeks to trace back')
?>
