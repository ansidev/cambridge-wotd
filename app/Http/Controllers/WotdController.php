<?php

namespace App\Http\Controllers;

use App\Contracts\WotdService;
use Illuminate\Http\Request;


class WotdController extends Controller
{
    /**
     * Wotd Service
     *
     * @var WotdService
     */
    private $wotdService;

    /**
     * Constructor
     *
     * @param WotdService $wotdService
     */
    public function __construct(WotdService $wotdService)
    {
        $this->wotdService = $wotdService;
    }

    /**
     * Get latest Cambridge Word of the day
     *
     * @return mixed Json Data for latest Cambridge Word of the day
     */
    public function getWotdAction()
    {
        $wotd = $this->wotdService->getWordOfTheDay();
        $status = 200;
        if (array_key_exists('error', $wotd)) {
            $status = $wotd['error'];
        }
        return response()->json($wotd, $status);
    }
}
