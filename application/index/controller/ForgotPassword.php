<?php

namespace app\index\controller;

use think\Controller;

class ForgotPassword extends Controller
{
   public function showLinkRequestFormOp()
   {
     return $this->fetch('password/email');
   }

    public function sendResetLinkEmailOp()
    {
        dump('sendResetLinkEmail');
    }

    public function showResetFormOp($token)
    {
        dump('showResetForm');
    }

    public function resetOp()
    {
        dump('reset');
    }
}
