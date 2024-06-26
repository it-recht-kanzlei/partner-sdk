<?php

    namespace Itrk\Helper;

    class ItrkApi {

        public function curl(): Curl {
            return Curl::create();
        }

    }
