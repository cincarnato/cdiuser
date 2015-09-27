<?php

namespace CdiUser\View\Helper;

use Zend\View\Helper\AbstractHelper;


/**
 * Description 
 *
 * @author cincarnato
 */
class JsKeepalive extends AbstractHelper {

    protected $options;
    
    public function __invoke() {
        $interval = $this->options->getKeepalive() * 1000;
        $result = "<script>
    
    function cdiUserKeepalive() {
        $.get('/cdiuser/keepalive', {}).done(function (data) {
        }

        );
    }
    (function () {
        setInterval(cdiUserKeepalive, $interval);
    })();

    </script>";
        return $result;
    }

    function getOptions() {
        return $this->options;
    }

    function setOptions($options) {
        $this->options = $options;
    }


}

?>
