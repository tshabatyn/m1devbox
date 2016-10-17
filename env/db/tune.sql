UPDATE core_config_data SET value='http://www.magento.local/' WHERE path IN ('web/secure/base_url', 'web/unsecure/base_url');
UPDATE admin_user SET username='admin', password=MD5('123123q') WHERE user_id=1;
