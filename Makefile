.PHONY: all test clean

all: test

clean:
	rm -rf key

key:
	@mkdir -p key
	@openssl genrsa -out key/key.pem
	@openssl rsa -in key/key.pem -pubout > key/key.pub

vendor:
	@composer install --dev

test: key vendor
	@vendor/bin/phpunit

	@echo ""
	@echo "You can now verify the generated JWT token on https://jwt.io."
	@echo "================================================="
	@echo "token: "
	@cat key/token.jwt
	@echo ""
	@echo "================================================="
	@echo "Private key: "
	@cat key/key.pem
	@echo "================================================="
	@echo "Public key: "
	@cat key/key.pub




