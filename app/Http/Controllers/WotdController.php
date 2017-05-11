<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class WotdController extends Controller
{
    private const WOTD_URL = "http://dictionary.cambridge.org/dictionary/english";
    private const WOTD_HTML_CSS_CLASS = ".wotd-hw";
    private const WOTD_LINK_CSS_CLASS = ".with-icons__content > a";

    public function getWotdAction()
    {
        $html = HtmlDomParser::str_get_html(file_get_contents(self::WOTD_URL));
        if ($html === false) {
            return response()->json([
                'error' => 500,
                'message' => 'Could not get word of the day. Please contact ansidev@gmail.com for supporting.'
            ]);
        }
        // Find word of the day
        $wotd_html    = $html->find(self::WOTD_HTML_CSS_CLASS);
        $wotd_meaning = $wotd_html[0]->nextSibling();
        $wotd_link    = $html->find(self::WOTD_LINK_CSS_CLASS);

        // Build WOTD object
        $wotd = [
            'word'    => $wotd_html[0]->plaintext,
            'meaning' => $wotd_meaning->plaintext,
            'url'     => $wotd_link[0]->href
        ];

        return response()->json($wotd);
    }
}
