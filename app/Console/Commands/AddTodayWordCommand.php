<?php

namespace App\Console\Commands;

use App\Wotd\WotdServiceUtils;
use Firebase;
use Illuminate\Console\Command;

class AddTodayWordCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'job:add-today-word';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Add today english word to Firebase database";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $wotd = WotdServiceUtils::getWordOfTheDay();
        $data = [
            $wotd['date'] => [
                'word' => $wotd['word'],
                'meaning' => $wotd['meaning'],
                'url' => $wotd['url'],
            ]
        ];
        Firebase::update('/wotd/', $data);
    }

}