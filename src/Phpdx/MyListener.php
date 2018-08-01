<?php

namespace Phpdx;

class MyListener {
    
    protected function processWebPost($commands) {
        sleep(5);
        return true;
    }

    /**
     * Reports error if worker dies.
     */
    public function shutdown() {
        $error = error_get_last();
        if ($error['type'] === E_ERROR) {
            error_log(sprintf('%s shut down: %s', __CLASS__, json_encode($error)));
        }
    }

}
