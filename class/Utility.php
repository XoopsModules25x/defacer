<?php namespace XoopsModules\Defacer;

use Xmf\Request;
use XoopsModules\defater;
use XoopsModules\Defacer\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
