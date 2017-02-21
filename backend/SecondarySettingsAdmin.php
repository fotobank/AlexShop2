<?php
/*************************************************
  Framework Component
  name      AlexShop_CMS
  created   by Alex production
  version   1.0
  author    Alex Jurii <alexjurii@gmail.com>
  Copyright (c) 2013 - 2016
 ************************************************/


use api\Registry;

class SecondarySettingsAdmin extends Registry {


    public function fetch() {
        $managers = $this->managers->get_managers();
        $this->design->assign('managers', $managers);



        return $this->design->fetch('secondary_settings.tpl');
    }
}
