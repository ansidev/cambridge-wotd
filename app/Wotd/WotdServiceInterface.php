<?php
namespace App\Wotd;

interface WotdServiceInterface
{
    public function getWordOfTheDay();

    public function getAllWords();
}
