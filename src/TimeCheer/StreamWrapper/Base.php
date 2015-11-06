<?php

require_once dirname(__FILE__) . '/Interface.php';

abstract class TimeCheer_StreamWrapper_Base implements TimeCheer_StreamWrapper_Interface {

    /**
     * Stream context resource.
     *
     * @var Resource
     */
    public $context;

}
