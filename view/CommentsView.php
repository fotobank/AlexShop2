<?php

class Comments extends View
{
	public function fetch()
	{
		return $this->design->fetch('comments/comments.tpl');
	}
}