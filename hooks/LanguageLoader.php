<?php
class LanguageLoader
{
    function initialize() {

        $ci = get_instance();
      
        $site_lang = $ci->session->userdata('language');

        if ($site_lang) {
            $ci->lang->load('label',$ci->session->userdata('language'));
        } else {
            $ci->lang->load('label','english');
        }

        
    }
}

?>