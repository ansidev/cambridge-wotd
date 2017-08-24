<?php

namespace App\Http\Controllers;

use App\Wotd\WotdServiceInterface;

class WotdController extends Controller
{
    /**
     * Wotd Service
     *
     * @var WotdServiceInterface
     */
    private $wotdService;

    /**
     * Constructor
     *
     * @param WotdServiceInterface $wotdService
     */
    public function __construct(WotdServiceInterface $wotdService)
    {
        $this->wotdService = $wotdService;
    }

    /**
     * Get all english words
     *
     * @return mixed
     */
    public function getWordsAction()
    {
        $wotd = $this->wotdService->getAllWords();
        $status = 200;
        if (array_key_exists('error', $wotd)) {
            $status = $wotd['error'];
        }
        return response()->json($wotd, $status);
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
