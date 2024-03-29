<?php

namespace System\Email\Drivers;

defined('DS') or exit('No direct access.');

use System\Log as BaseLog;

class Log extends Driver
{
    /**
     * Mulai proses transmisi data.
     *
     * @return bool
     */
    protected function transmit()
    {
        $message = $this->build();
        BaseLog::info(sprintf('Email sent: %s (to: %s)', e($this->subject), e(static::format($this->to))), [
            'to' => e(static::format($this->to)),
            'subject' => e($this->subject),
            'header' => e(sprintf('%s', $message['header'])),
            'body' => e(sprintf('%s', $message['body'])),
        ]);

        return true;
    }
}
