<?php

namespace Casperlaitw\LaravelFbMessenger\Messages;

use Casperlaitw\LaravelFbMessenger\Contracts\Messages\Message;

/**
 * Class TextMessage
 * @package Casperlaitw\LaravelFbMessenger\Messages
 */
class TextWithTag extends Message
{
    use Quickable;

    /** @var */
    private $message;
    
    /** @var string - const from FacebookDocs -> https://developers.facebook.com/docs/messenger-platform/send-messages/message-tags#sending */
    private $tag;

    /**
     * TextMessage constructor.
     *
     * @param $sender
     * @param $message
     */
    public function __construct($sender, $message, $tag)
    {
        parent::__construct($sender);
        $this->message = $message;
        $this->tag = $tag;
        $this->bootQuick();
    }

    /**
     * To array for send api
     *
     * @return array
     */
    public function toData()
    {
        $params = [
            'recipient' =>  [
                'id' => $this->getSender(),
            ],
            'message' => [
                'text' => $this->message,
            ],
        ];

        if ($this->tag) {
            $params['messaging_type'] = 'MESSAGE_TAG';
            $params['tag'] = $this->tag;
        }

        return $this->makeQuickReply($params);
    }
}
