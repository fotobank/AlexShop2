<?php

use api\Registry;

class StatsAdmin extends Registry {
    
    public function fetch() {
        return $this->design->fetch('stats.tpl');
    }
    
}
