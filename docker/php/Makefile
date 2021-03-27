default: build

build:
	@(echo "-> Build php image (local)")
	docker build -t registry.gitlab.com/rosatom/core/docker/php .
	@(echo "-> Done")

push:
	@(echo "-> Build ans push php image (local)")
	docker build -t registry.gitlab.com/rosatom/core/docker/php .
	docker push registry.gitlab.com/rosatom/core/docker/php
	@(echo "-> Done")
