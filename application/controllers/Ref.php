<?php

class Ref extends CI_Controller {
    /**
     * Index Page for this controller.
     * @author      Shubham patil
     * @copyright   03.09.2019
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $url = $this->input->get('url');
        $ref = $this->input->get('id');
        $cookie = array(
            'name' => 'refcookie',
            'value' => $ref,
            'expire' => '86500',
        );
        $this->input->set_cookie($cookie);
        redirect($url);
    }

}
