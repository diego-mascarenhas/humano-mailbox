<?php

namespace Idoneo\HumanoMailbox\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class MailboxController extends BaseController
{
	public function index()
	{
		return view('humano-mailbox::mailbox.index');
	}
}


