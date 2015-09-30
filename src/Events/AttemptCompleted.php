<?php namespace XREmitter\Events;

class AttemptCompleted extends Event {
    protected static $verb_display = [
        'en' => 'completed'
    ];

    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     * @override Event
     */
    public function read(array $opts) {
        return array_merge_recursive(parent::read($opts), [
            'verb' => [
                'id' => 'http://adlnet.gov/expapi/verbs/completed',
                'display' => $this->readVerbDisplay($opts),
            ],
            'result' => [
                'score' => [
                    'raw' => $opts['attempt_result'],
                ],
                'completion' => $opts['attempt_completed'],
                'duration' => $opts['attempt_duration'],
            ],
            'object' => [
                $this->readModule($opts),
            ],
            'context' => [
                'contextActivities' => [
                    'grouping' => [
                        $this->readCourse($opts),
                        'id' => $opts['attempt_url'],
                        'definition' => [
                            'type' => $opts['attempt_type'],
                            'name' => [
                                $opts['context_lang'] => $opts['attempt_name'],
                            ],
                            'extensions' => [
                                $opts['attempt_ext_key'] => $opts['attempt_ext']
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}