APP_CONSOLE=php bin/console

dev_clear_cache:
	rm -rf var/cache/dev
	$(APP_CONSOLE) shf_api:cache:clear --env=dev
	$(APP_CONSOLE) cache:clear --env=dev

test_clear_cache:
	rm -rf var/cache/test
	$(APP_CONSOLE) shf_api:cache:clear --env=test
	$(APP_CONSOLE) cache:clear --env=test

test_clear_custom_cache:
	rm -rf var/cache/test
	$(APP_CONSOLE) shf_api:cache:clear --env=test

dev_reset_db:
	$(APP_CONSOLE) doctrine:database:drop --if-exists --force --env=dev
	$(APP_CONSOLE) doctrine:database:create --env=dev
	$(APP_CONSOLE) doctrine:schema:update --force --env=dev
	$(APP_CONSOLE) hautelook:fixtures:load --no-interaction  --env=dev
	$(MAKE) dev_clear_cache

test_reset_db:
	rm -rf var/shf_test.sqlite
	$(APP_CONSOLE) doctrine:database:create --env=test
	$(APP_CONSOLE) doctrine:schema:update --force --env=test
	$(APP_CONSOLE) hautelook:fixtures:load --no-interaction --env=test
	$(APP_CONSOLE) shf_api:cache:clear --env=test
