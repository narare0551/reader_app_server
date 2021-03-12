<?php
require_once 'route.php';
$route = new Route();
//라우트 설정하는 부분\
$route->add('/', 'MainController');
// $route->add('/dashboard/{type}', 'DashboardController');
// $route->add('/company/{type}', 'CompanyController');
// $route->add('/login/{type}', 'LoginController');
// $route->add('/member/{type}', 'MemberManagementController');
// $route->add('/setup_menu/{type}', 'MenuManagementController');
// $route->add('/setup_theme/{type}', 'ThemeManagementController');
// $route->add('/code/{type}', 'CodeController'); // 코드관리
// $route->add('/item/{type}', 'ItemController'); // 품목관리
// $route->add('/rack/{type}', 'RackController'); // 창고관리
// $route->add('/inventory/{type}', 'InventoryController'); // 재고관리
// $route->add('/order/{type}', 'OrderController'); // 발주관리
// $route->add('/receipt/{type}', 'ReceiptController'); // 입고관리
// $route->add('/outgoing/{type}', 'OutgoingController'); // 출고관리
// $route->add('/employee/{type}', 'EmployeeController'); // 직원관리

// $route->add('/days_scan/{type}','ScandataController');//기간별 스캔 통계
// $route->add('/day_menu_scan/{type}','DayMenuScanController');//공정별 스캔 분포
// $route->add('/device_scan/{type}','DeviceScanController');//기기별 스캔 통계
// $route->add('/device_battery/{type}','DeviceBatteryController');//기기별 배터리 잔량
// $route->add('/monitoring/{type}','MonitoringController');//기기별 배터리 잔량

// $route->add('/aiapi/{type}', 'AiAPIController');      //ai전용 api
// $route->add('/error', 'ErrorController');
// $route->add('/pushalrams/{type}','PushAlramsController');

$route->add('/user/{type}','UserController');
$route->add('/item/{type}','ItemController');
$route->add('/aiapi/{type}', 'AiAPIController');
$route->submit();
