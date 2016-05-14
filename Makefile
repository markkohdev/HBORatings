default: run

MANAGER=hboratings/manage.py
IP=0.0.0.0
PORT=5001

TIMESTAMP=$(shell /bin/date "+%m%d%Y--%H-%M-%S")

SEEDFILE:=seed_data/seed.json
DUMPFILE:=db_backups/dump_$(TIMESTAMP).json

###########################################
# Install
###########################################
install: requirements.txt
	sudo pip install -r requirements.txt

###########################################
# Migrations
###########################################
makemigrations: install $(MANGER)
	python $(MANAGER) makemigrations $(MODULE);

migrate: makemigrations
	python $(MANAGER) migrate;

dry-migrate: $(MANAGER)
	python $(MANAGER) makemigrations --dry-run --verbosity 3 $(MODULE);

seed: install $(MANAGER)
	python $(MANAGER) loaddata $(SEEDFILE)

dump: $(MANAGER)
	python $(MANAGER) dumpdata --natural-foreign --exclude auth.permission --exclude contenttypes --indent 4 > $(DUMPFILE)

###########################################
# Runners
###########################################
run: install $(MANAGER)
	python $(MANAGER) runserver $(IP):$(PORT)

runserver: install $(MANAGER)
	nohup python $(MANAGER) runserver $(IP):$(PORT) >> logs/stdout.log 2>&1 &

shell: install $(MANAGER)
	python $(MANAGER) shell_plus

kill:
	pkill -f $(MANAGER)

runscript:
	python $(MANAGER) runscript $(SCRIPT)

###########################################
# Cleanup
###########################################
clean:
	find . -name "*.pyc" -print0 | xargs -0 rm

empty-database: $(MANAGER)
	python $(MANAGER) flush

drop-database: $(MANAGER)
	python $(MANAGER) reset_db
