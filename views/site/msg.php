<?php
// сообщение об ошибке или успехе
if ($msg != null) {
    $this->params['msg'] = $msg[0];
    if ($msg[1] == 1) {
        $this->beginContent('@app/views/layouts/msg_green.php');
        $this->endContent();
    } else {
        $this->beginContent('@app/views/layouts/msg_red.php');
        $this->endContent();
    }
}
