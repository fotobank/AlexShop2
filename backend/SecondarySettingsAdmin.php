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

        if($this->request->method('POST')) {
            $this->settings->site_name = $this->request->post('site_name');
            $this->settings->phone1 = $this->request->post('phone1');
            $this->settings->phone2 = $this->request->post('phone2');
            $this->settings->phone3 = $this->request->post('phone3');
            $this->settings->company_name = $this->request->post('company_name');
            $this->settings->date_format = $this->request->post('date_format');
            $this->settings->admin_email = $this->request->post('admin_email');


            $this->design->assign('message_success', 'saved');

        }

        return $this->design->fetch('secondary_settings.tpl');
    }
}
