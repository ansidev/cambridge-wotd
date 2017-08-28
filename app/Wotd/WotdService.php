<?php

namespace App\Wotd;

class WotdService implements WotdServiceInterface
{
    /**
     * Get latest Cambridge Word of the day
     *
     * @return array Word of the day if success or an error
     */
    public function getWordOfTheDay()
    {
        return WotdServiceUtils::getWordOfTheDay();
    }

    /**
     * Get all words
     *
     * @return mixed
     */
    public function getAllWords()
    {
        return WotdServiceUtils::getAllWords();
    }
}
