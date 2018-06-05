<?php

namespace CoreBundle\Utils;

class GeneratingUtils
{
	public static function generateUniqueFileName()
	{
		return md5(uniqid());
	}
}
