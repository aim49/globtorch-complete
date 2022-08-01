<?php

namespace App\Traits;

trait MessageTrait
{
    protected function send_message($destinations, $message)
    {
        $username = 'Globtorch';
        $token = '4253fdb80ea9500748b0852389feb134';
        $bulksms_ws = 'http://portal.bulksmsweb.com/index.php?app=ws';
        $ws_str = $bulksms_ws . '&u=' . $username . '&h=' . $token . '&op=pv';
        $ws_str .= '&to=' . urlencode($destinations) . '&msg='.urlencode($message);
        $ws_response = @file_get_contents($ws_str);
    }
}

?>