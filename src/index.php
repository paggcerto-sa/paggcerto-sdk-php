<?php
/**
 * User: erick.antunes
 * Date: 30/07/2018
 * Time: 17:04
 */
require "../vendor/autoload.php";

use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;
use Paggcerto\Service\CityService;


function test()
{
    $paggSandbox = new Paggcerto(new Auth(), "vL");
    $paggSandbox->createNewSession();
    $cities = $paggSandbox->city()->getRequest(sprintf(CityService::SEARCH_CITIES, "SE"));
    echo (json_encode($cities));
}
?>
<html>
<body>
<?php test(); ?>
</body>
</html>
