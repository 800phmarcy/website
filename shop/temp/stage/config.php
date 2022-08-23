<?php

define('HTTP_SERVER', 'https://staging.800pharmacy.ae/');
define('HTTP_CATALOG', 'https://staging.800pharmacy.ae/');

// HTTPS
define('HTTPS_SERVER', 'https://staging.800pharmacy.ae/');
define('HTTPS_CATALOG', 'https://staging.800pharmacy.ae/');


// DIR
define('DIR_APPLICATION', '/home/staging/public_html/catalog/');
define('DIR_SYSTEM', '/home/staging/public_html/system/');
define('DIR_IMAGE', '/home/staging/public_html/image/');
define('DIR_STORAGE', '/home/staging/public_html/storage/');
define('DIR_CATALOG', '/home/staging/public_html/catalog/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'dashboard');
define('DB_PASSWORD', 'dashboard@800');
//define('DB_DATABASE', 'dashboard_v2');
define('DB_DATABASE', 'demo');
define('DB_PORT', '3306');
define('DB_PREFIX', 'ph_');







define('UPLOAD_DIR_REGISTERED', '/home/staging/public_html/uploads/documents/registered/');

define('FAMILY_IMAGE_URL', HTTP_SERVER.'uploads/documents/registered/family/avators/');
define('FAMILY_ID_IMAGE_URL', HTTP_SERVER.'uploads/documents/registered/family/emiratesid/');
define('FAMILY_INSURANCE_IMAGE_URL', HTTP_SERVER.'uploads/documents/registered/family/insurancecard/');
define('ID_IMAGE_URL', HTTP_SERVER.'uploads/documents/registered/emiratesid/');
define('INSURANCE_IMAGE_URL', HTTP_SERVER.'uploads/documents/registered/insurancecard/');
define('PROFILE_IMAGE_URL', HTTP_SERVER.'uploads/documents/registered/avators/');
define('OTHERS_IMAGES_URL', HTTP_SERVER.'uploads/others/');
define('ATTACHMENTS_IMAGE_URL', 'uploads/documents/registered/attachments/');
define('REGISTERED_IMAGES_URL', HTTP_SERVER.'uploads/documents/registered/');


define('CASHBACK',10);

//Network international
define("SANDBOX_OUTLETID", "258d482a-8576-420d-8bf0-a49dabb00ce3");
define("SANDBOX_AUTHORIZATION_CODE", "MTQwN2ZlN2MtNmQ2YS00NGMwLTliOTctZmNjOThhMjU2YjgxOjRlZTZjOTVlLWIwYTEtNGRlNi1iYzliLTczZWM3ZmU3ODkzOA==");
define("SANDBOX_NITOKENURL", "https://identity-uat.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token");
define("SANDBOX_NIURL", "https://api-gateway-uat.ngenius-payments.com/");
define("OUTLETID", "ee53abb9-5470-4a78-95cf-840db864f832");
define("AUTHORIZATION_CODE", "YThiMzAwYzctODQ1ZS00ZDFhLTlhYjMtNjQzN2VlZDBiZDcyOmViNTM4Mzg4LWFkMjYtNGE0OS05ZGRjLTQ4ZTgyMTIyMDdmOQ==");
define("NITOKENURL", "https://api-gateway.ngenius-payments.com/identity/auth/access-token");
define("NIURL", "https://api-gateway.ngenius-payments.com/");
define("AUTH", "AUTH");
define("SALE", "SALE");
define("REAL_NAME", "ni");
//Network international
define('DEFAULT_COORDINATE_LAT', 25.1473545);
define('DEFAULT_COORDINATE_LNG', 55.2419967);
define('DEFAULT_ZOOM_LEVEL', 16);

//Notifications
// define("SMS_USERNAME", "marina@smartcall.ae");
// define("SMS_PASSWORD", "mp101");
define("SMS_USERNAME", "marinaapi");
define("SMS_PASSWORD", "mpi908");

define("ORDER_UNDER_PROCESS", "Dear {CUSTOMER}, your order is accepted and in under process!");
define("ON_DELIVERY", "Dear {CUSTOMER}, your order is dispatched already!");
define("ORDER_DELIVERED", "Dear {CUSTOMER}, your order delivered successfully!");
define("OFFICE_LAT", "25.1473545");
define("OFFICE_LNG", "55.2441854");
