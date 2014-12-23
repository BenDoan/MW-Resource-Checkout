<?php
// Application constants
define('DEFAULT_VIEW','calendar');
define('DEFAULT_ADMIN_PANEL_ITEM', 'user');
define('NUM_BLOCKS', intval(getSettingValue('Number of Blocks')));
define('APP_NAME', getSettingValue('Site Name'));
define('DISP_BADGES', stringToBool(getSettingValue('Display table counts')));
define('SITE_EMAIL', getSettingValue('Site Email'));
define('SALT', '9cd6ce28a6092be779a682f7ce38357c');
