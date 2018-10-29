<?php

namespace App;

class GCMAlertEagerLoad extends GCMAlert
{
    protected $table = 'gcm_alerts';

    protected $with = ['owner'];
}
