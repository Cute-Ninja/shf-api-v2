APP_CONSOLE=php bin/console

dev_clear_cache:
	rm -rf var/cache/dev
	$(APP_CONSOLE) shf_api:cache:clear --env=dev
	$(APP_CONSOLE) cache:clear --env=dev

dev_reset_db:
	$(APP_CONSOLE) doctrine:database:drop --if-exists --force --env=dev
	$(APP_CONSOLE) doctrine:database:create --env=dev
	$(APP_CONSOLE) doctrine:schema:update --force --env=dev
	$(APP_CONSOLE) hautelook:fixtures:load --no-interaction  --env=dev

test_reset_db:
	$(APP_CONSOLE) doctrine:database:drop --if-exists --force --env=test
	$(APP_CONSOLE) doctrine:database:create --env=test
	$(APP_CONSOLE) doctrine:schema:update --force --env=test
	$(APP_CONSOLE) hautelook:fixtures:load --no-interaction  --env=test