<?php

include './vendor/simple_html_dom.php';

class NumberParser {
    public $user = null;

    public function setIGUser($username){
        $parse = file_get_html('https://www.instagram.com/'.$username.'/');
        $meta = $parse->find('script[type="application/ld+json"]')[0]->innertext;
        $this->user = json_decode($meta);
    }

    public function get(){
        if( $this->user ) {
            $data = [];

            if( strpos($this->user->url, 'api.whatsapp.com') || strpos($this->user->url, 'wp.me') || strpos($this->user->url, 'wa.me') ) {
                $data['number'] = substr($this->user->url, -12);
            } else {
                $getNumber = $this->search($this->user->description);
                if( $getNumber ) {
                    $data['number'] = $getNumber;
                } else {
                    $data['original_description'] = $this->user->description;
                    $data['number'] = '';
                }
            }

            return $data;
        }
    }

    public function search($string) {
        $search = strpos($string, ' 05');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' 905');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' +905');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' +905');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' 0 5');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' :5');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' :05');
        if( $search )
            return $this->prepareNumber($string, $search);
        $search = strpos($string, ' :905');
        if( $search )
            return $this->prepareNumber($string, $search);
        return false;
    }

    protected function prepareNumber($text, $search){
        return preg_replace('/([^0-9])/i', '', substr($text, $search, 16));
    }

}
