<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * All spam keywords
     *
     * @var array
     */
    protected $keywords = [
        'sex',
        'dating',
        'girl',
        'inсome',
        'сrуptoсurrеncу',
        'earnings',
        'suссеss story',
        'passive income',
        'hоw tо mаkе',
        'еаsiest wаy to earn',
        'eаrn money',
        'sеху',
        'girls',
        'adult',
        'bitсoin',
        'alt.com',
        'pаid survеуs',
        'porn',
        'casino',
        'viagra',
        'ass',
        'butt',
        'big booty pics',
    ];

    /**
     * Detect spam
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (preg_match("/\b$keyword\b/i", $body)) {
                throw new Exception("spam entry detection.");
            }
        }
    }

}
