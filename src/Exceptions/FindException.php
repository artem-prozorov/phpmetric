<?php

namespace PhpMetric\Exceptions;

class FindException extends \OutOfBoundsException
{
    // protected $code;

    // protected $identifier;

    // protected $context;

    // protected $message;

    // protected $positiveTemplate = 'Cannot find needle %s "%s" in context: "%s"';

    // protected $negatedTemplate = 'Needle %s "%s" found in context "%s" but it shouldnt be here';

    // /**
    //  * __construct.
    //  *
    //  * @access	public
    //  * @param	mixed	$code      	
    //  * @param	mixed	$identifier	
    //  * @param	mixed	$context   	
    //  * @param	mixed	$negated   	
    //  * @return	void
    //  */
    // public function __construct($code, $identifier, $context, $negated)
    // {
    //     $this->code = $code;
    //     $this->identifier = $identifier;
    //     $this->context = $context;

    //     $template = $negated ? $this->negatedTemplate : $this->positiveTemplate;

    //     $this->message = sprintf(
    //         $template,
    //         $this->code,
    //         $this->identifier,
    //         $this->context
    //     );
    // }
}
